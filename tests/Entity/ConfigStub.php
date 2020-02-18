<?php

namespace App\Tests\Entity;

use App\Entity\Config;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class ConfigStub extends Config
{
    /**
     * @param array $override
     */
    public function __construct(array $override = [])
    {
        $this->vacationDays = $override['vacationDays'] ?? 30;
        $this->workingTime = $override['workingTime'] ?? 462;
        $this->workingBreak = $override['workingBreak'] ?? 30;
        $this->timeAccount = $override['timeAccount'] ?? 0;
    }
}
