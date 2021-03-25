<?php

/**
 * @link https://www.shardimage.com/
 *
 * @copyright Copyright (c) 2021 Shardimage
 * @license https://github.com/shardimage/shardimage-php/blob/master/LICENCE.md
 */

namespace shardimage\shardimagephp\indexiterator;

use PHPUnit\Framework\TestCase;
use shardimage\shardimagephp\auth\Client;
use shardimage\shardimagephp\indexiterator\services\FakeService;
use shardimage\shardimagephp\models\IndexIterator;

class IndexIteratorTest extends TestCase
{
    /**
     * @return IndexIterator
     */
    private function getIterator()
    {
        $client = new Client(['useMsgPack' => false]);
        $fakeService = new FakeService($client);
        return $fakeService->indexIterator();
    }

    public function testSimpleIterate()
    {
        $iterator = ($this->getIterator());
        $count = 0;
        while ($iterator->valid()) {
            $count++;
            $iterator->next();
        }
        $this->assertSame($count, count(FakeService::$fakeData));
        $this->assertSame($iterator->valid(), false);
        $this->assertSame($iterator->getNextPageToken(), null);
    }

    public function testIterateTwice()
    {
        $iterator = ($this->getIterator());
        $count = 0;
        while ($iterator->valid()) {
            $count++;
            $iterator->next();
            if (!$iterator->valid() && $count < count(FakeService::$fakeData) * 2) {
                $iterator->rewind();
            }
        }
        $this->assertSame($count, count(FakeService::$fakeData) * 2);
        $this->assertSame($iterator->valid(), false);
        $this->assertSame($iterator->getNextPageToken(), null);
    }

    public function testUnfinishedIterate()
    {
        $iterator = ($this->getIterator())->withIndexParams(['maxResult' => 3]);
        $count = 0;
        while ($iterator->valid()) {
            $count++;
            $iterator->next();
            break;
        }
        $this->assertNotSame($count, count(FakeService::$fakeData));
        $this->assertNotSame($iterator->getNextPageToken(), null);
        $this->assertSame($iterator->valid(), true);
    }

    public function testContinuedBreakIterate()
    {
        $iterator = ($this->getIterator())->withIndexParams(['maxResult' => 3]);
        $count = 0;
        while ($iterator->valid()) {
            $count++;
            $iterator->next();
            break;
        }
        $this->assertNotSame($count, count(FakeService::$fakeData));
        $this->assertNotSame($iterator->getNextPageToken(), null);
        $this->assertSame($iterator->valid(), true);
        while ($iterator->valid()) {
            $count++;
            $iterator->next();
        }
        $this->assertSame($count, count(FakeService::$fakeData));
        $this->assertSame($iterator->valid(), false);
        $this->assertSame($iterator->getNextPageToken(), null);
    }

    public function testContinuedNewIterate()
    {
        $iterator = ($this->getIterator())->withIndexParams(['maxResult' => 3]);
        while ($iterator->valid()) {
            break;
        }
        $nextPageToken = $iterator->getNextPageToken();
        $this->assertNotSame($nextPageToken, null);
        $this->assertSame($iterator->valid(), true);
        unset($iterator);
        $iterator2 = $this->getIterator()->withIndexParams(['maxResult' => 3])->withNextPageToken($nextPageToken);
        while ($iterator2->valid()) {
            $iterator2->next();
        }
        $this->assertSame($iterator2->valid(), false);
        $this->assertSame($iterator2->getNextPageToken(), null);
    }

    public function testContinueFinishedIterate()
    {
        $iterator = ($this->getIterator())->withIndexParams(['maxResult' => 3]);
        $count = 0;
        while ($iterator->valid()) {
            $count++;
            $iterator->next();
        }
        $this->assertSame($count, count(FakeService::$fakeData));
        $this->assertSame($iterator->getNextPageToken(), null);
        $this->assertSame($iterator->valid(), false);
        $count = 0;
        $iterator->rewindAll();
        while ($iterator->valid()) {
            $count++;
            $iterator->next();
        }
        $this->assertSame($count, count(FakeService::$fakeData));
        $this->assertSame($iterator->getNextPageToken(), null);
        $this->assertSame($iterator->valid(), false);
    }
}
