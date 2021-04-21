<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2021 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\models;

use Iterator;
use shardimage\shardimagephp\services\Service;
use shardimage\shardimagephpapi\web\exceptions\TooManyRequestsHttpException;

class IndexIterator implements Iterator
{
    const START_INDEX = 0;

    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    private $indexParams;

    /**
     * @var int
     */
    private $position = self::START_INDEX;

    /**
     * @var array
     */
    private $result = [];

    /**
     * @var null|callable
     */
    private $rateLimitCallable;

    /**
     * @var Service 
     */
    private $service;

    /**
     * @var bool
     */
    private $isStopping = false;

    /**
     * @var string|null
     */
    private $currentPageToken = null;

    /**
     * @var string|null
     */
    private $nextPageToken = null;

    /**
     * @var null|bool
     */
    private $hasNextPageToken = null;

    /**
     * Constructor
     * @param Service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @param IndexParams|array $indexParams
     * @return static
     */
    public function withIndexParams($indexParams)
    {
        if (!is_array($indexParams) && !($indexParams instanceof IndexParams)) {
            throw new \InvalidArgumentException('Not supported type of $indexParams.');
        }
        $new = clone $this;
        $new->indexParams = is_object($indexParams) ? $indexParams->toArray(true) : $indexParams;
        if (isset($new->indexParams['pageToken']) && is_string($new->indexParams['pageToken'])) {
            $new->nextPageToken = $new->indexParams['pageToken'];
        } elseif (!isset($new->indexParams['pageToken']) || null === $new->indexParams['pageToken']) {
            $new->nextPageToken = null;
        } else {
            throw new \RuntimeException('Not supported nextPageToken.');
        }
        $new->hasNextPageToken = null;
        return $new;
    }

    /**
     * @param array $params
     * @return static
     */
    public function withParams(array $params)
    {
        $new = clone $this;
        $new->params = $params;
        return $new;
    }

    public function withoutIndexParams()
    {
        $new = clone $this;
        $new->indexParams = [];
        return $new;
    }

    public function withoutParams()
    {
        $new = clone $this;
        $new->params = [];
        return $new;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->position = self::START_INDEX;
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->result[$this->position];
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        if ($this->isStopping) {
            return false;
        }
        if (($this->position === self::START_INDEX && $this->result === []) || (!isset($this->result[$this->position]) && true === $this->hasNextPageToken)) {
            $this->loadResult();
        }
        return isset($this->result[$this->position]);
    }

    /**
     * Reset the iterator
     */
    public function rewindAll()
    {
        if (isset($this->indexParams['pageToken'])) {
            unset($this->indexParams['pageToken']);
        }
        if (null !== $this->nextPageToken) {
            $this->nextPageToken = null;
        }
        $this->loadResult();
    }

    /**
     * Adding rate limitation logic
     *
     * @param callable $callable
     * @return static
     * @throws \InvalidArgumentException
     */
    public function withRateLimitTrap(callable $callable)
    {
        $new = clone $this;
        $new->rateLimitCallable = $callable;
        return $new;
    }

    public function getCurrentPageToken(): ?string
    {
        return $this->currentPageToken;
    }

    public function getNextPageToken(): ?string
    {
        return $this->nextPageToken;
    }

    public function getHasNextPage(): bool
    {
        if (null === $this->hasNextPageToken) {
            throw new \LogicException('The next page token availability cannot be determined.');
        }
        return $this->hasNextPageToken;
    }

    /**
     * @return static
     */
    public function withNextPageToken(string $nextPageToken)
    {
        $new = clone $this;
        $new->nextPageToken = $nextPageToken;
        $new->hasNextPageToken = null;
        return $new;
    }

    /**
     * @return static
     */
    public function withoutNextPageToken()
    {
        $new = clone $this;
        $new->nextPageToken = null;
        $new->hasNextPageToken = null;
        return $new;
    }

    /**
     * Stopping the iteration.
     */
    public function stop(): void
    {
        $this->isStopping = true;
    }

    /**
     * Load index results.
     * @throws TooManyRequestsHttpException
     */
    private function loadResult()
    {
        $this->rewind();
        if (null !== $this->getNextPageToken()) {
            $this->indexParams['pageToken'] = $this->getNextPageToken();
        }
        $success = false;
        do {
            try {
                $result = $this->runIndexRequest($this->params ?? [], $this->indexParams ?? []);
                $this->currentPageToken = $this->getNextPageToken();
                $this->nextPageToken = false === $result->nextPageToken ? null : $result->nextPageToken;
                $this->hasNextPageToken = false !== $result->nextPageToken;
                $this->result = $result->models;
                $success = true;
            } catch (TooManyRequestsHttpException $ex) {
                $this->handleRateLimitTrap($ex);
            }
        } while (!$this->isStopping && !$success);
    }

    protected function runIndexRequest(array $params, array $indexParams)
    {
        return $this->service->index($params, $indexParams);
    }

    /**
     * @param TooManyRequestsHttpException $ex
     * @throws TooManyRequestsHttpException
     */
    private function handleRateLimitTrap(TooManyRequestsHttpException $ex)
    {
        if (null === $this->rateLimitCallable) {
            throw $ex;
        }
        call_user_func_array($this->rateLimitCallable, [$ex, $this]);
    }
}
