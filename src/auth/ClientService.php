<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2018 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\auth;

use shardimage\shardimagephpapi\services\Client;
use shardimage\shardimagephp\helpers\LoggerHelper;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class ClientService extends Client implements LoggerAwareInterface
{
    /**
     * @var bool Enable debugging
     */
    public $debug = false;

    /**
     * @var LoggerInterface Logger instance.
     */
    public $logger;

    /**
     * @inheritDoc
     */
    public function log($level, $event)
    {
        if ($this->debug && $this->logger) {
            $this->logger->log(LoggerHelper::phpToPsrLevel($level), $event);
        }
    }

    /**
     * @inheritDoc
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
