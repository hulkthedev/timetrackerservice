<?php

namespace App\Tests\Entity;

use App\Entity\Config;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class ConfigStub extends Config
{
    public function __construct()
    {
        $this->vacationDays = 30;
        $this->workingTime = 480;
        $this->workingBreak = 30;
        $this->timeAccount = 0;
    }
}
