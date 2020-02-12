<?php

namespace App\Tests\Entity;

use App\Entity\Day;
use App\Usecase\Modes;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class DayStub extends Day
{
    public function __construct()
    {
        $this->employerId = 1;
        $this->employerName = 'Google';

        $this->workingTimeId = 1;
        $this->workingTimeDescription = 'Fulltime';

        $this->weekDay = 1;
        $this->mode = Modes::MODE_WORKING;
        $this->date = '2020-01-01';
        $this->begin = '09:48:00';
        $this->end = '18:04:00';
        $this->delta = 34;
        $this->break = 30;
    }
}
