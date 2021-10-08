<?php

namespace App\Repository;

use App\Entity\Config;
use App\Tests\Cache\ApcuCacheItemPoolStub;
use App\Tests\Entity\ConfigStub;
use Exception;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class MariaDbConfigRepositoryStub extends MariaDbConfigRepository
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function getFromRepo(int $employerId, int $employerWorkingTimeId): Config
    {
        return new ConfigStub();
    }

    /**
     * @return CacheItemPoolInterface
     * @throws Exception
     */
    public function getCache(): CacheItemPoolInterface
    {
        return new ApcuCacheItemPoolStub();
    }
}
