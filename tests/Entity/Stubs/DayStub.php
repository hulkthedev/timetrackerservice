<?php

namespace App\Entity\Stubs;

use App\Entity\Day;
use App\Entity\EntityModes;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class DayStub extends Day
{
    public function __construct()
    {
        $this->id = 1;
        $this->date = '2020-01-01';
        $this->mode = EntityModes::MODE_WORKING;
        $this->begin = 1234567890123;
        $this->end = 1234567890567;
        $this->delta = 30;
    }
}
