<?php

namespace App\Entity;

use App\Entity\Stubs\DayStub;
use PHPUnit\Framework\TestCase;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class WeekTest extends TestCase
{
    public function testEntity(): void
    {
        $week = new Week();
        $week->number = 1;
        $week->delta = -30;

        for ($i = 0; $i < 5; $i++) {
            $week->days[] = new DayStub();
        }

        TestCase::assertInstanceOf(Week::class, $week);
        TestCase::assertEquals(-30, $week->delta);
        TestCase::assertEquals(5, count($week->days));
    }
}
