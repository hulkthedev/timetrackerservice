<?php

namespace App\Tests\Cache;

use App\Cache\CacheItem;
use PHPUnit\Framework\TestCase;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class CacheItemTest extends TestCase
{
    public function test_Entity(): void
    {
        $item = new CacheItem('unittest');
        $item->set(['foor' => 'bar'])
            ->expiresAfter(112233);

        TestCase::assertEquals('unittest', $item->getKey());
        TestCase::assertEquals(['foor' => 'bar'], $item->get());
        TestCase::assertEquals(112233, $item->getExpiry());
        TestCase::assertFalse($item->isHit());

        $item->expiresAt(new \DateTime()); // no effect
        TestCase::assertEquals(112233, $item->getExpiry());
    }
}
