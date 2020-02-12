<?php

namespace App\Tests\Entity;

use App\Entity\Week;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class WeekStub extends Week
{
    public function __construct()
    {
        $this->weekNo = 1;
        $this->weekDelta = 0;
        $this->weekDays = [
            new DayStub(),
            new DayStub(),
            new DayStub()
        ];
    }
}
