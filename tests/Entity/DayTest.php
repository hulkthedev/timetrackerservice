<?php

namespace App\Entity;

use App\Entity\Stubs\DayStub;
use PHPUnit\Framework\TestCase;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class DayTest extends TestCase
{
    public function testEntity(): void
    {
        $day = new DayStub();

        TestCase::assertInstanceOf(Day::class, $day);
        TestCase::assertEquals(1, $day->id);
        TestCase::assertEquals('2020-01-01', $day->date);
        TestCase::assertEquals(Modes::MODE_WORKING, $day->mode);
        TestCase::assertEquals('09:48:43', $day->begin);
        TestCase::assertEquals('18:04:32', $day->end);
        TestCase::assertEquals('+34', $day->delta);
    }
}
