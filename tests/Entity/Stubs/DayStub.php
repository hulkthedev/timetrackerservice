<?php

namespace App\Entity\Stubs;

use App\Entity\Day;
use App\Entity\Modes;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class DayStub extends Day
{
    public function __construct()
    {
        $this->id = 1;
        $this->mode = Modes::MODE_WORKING;
        $this->date = '2020-01-01';
        $this->begin = '09:48:43';
        $this->end = '18:04:32';
        $this->delta = '+34';
    }
}