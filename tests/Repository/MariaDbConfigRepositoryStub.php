<?php

namespace App\Repository;

use App\Entity\Config;
use App\Tests\Entity\ConfigStub;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class MariaDbConfigRepositoryStub extends MariaDbConfigRepository
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function getConfig(int $employerId, int $employerWorkingTimeId): Config
    {
        return new ConfigStub();
    }
}
