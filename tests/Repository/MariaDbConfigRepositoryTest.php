<?php

namespace App\Tests\Repository;

use App\Cache\CacheItem;
use App\Repository\Exception\DatabaseException;
use App\Repository\Mapper\MariaDbMapper;
use App\Repository\MariaDbConfigRepository;
use App\Tests\Cache\ApcuCacheItemPoolStub;
use App\Tests\Entity\ConfigStub;
use PHPUnit\Framework\TestCase;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class MariaDbConfigRepositoryTest extends TestCase
{
    private const EMPLOYER_ID = 112233;
    private const EMPLOYER_WORKING_TIME_ID = 12345678;

    private MariaDbMapper $mapper;
    private ApcuCacheItemPoolStub $pool;

    protected function setUp(): void
    {
        $this->mapper = new MariaDbMapper();
        $this->pool = new ApcuCacheItemPoolStub();
    }

    /**
     * @throws DatabaseException
     */
    public function test_getConfig_ExpectConfigFromCache(): void
    {
        $item = new CacheItem(CacheItem::PREFIX_CONFIG . self::EMPLOYER_ID . '_' . self::EMPLOYER_WORKING_TIME_ID);
        $item->set($this->mapper->mapToConfig(MariaDbFetcher::getConfig()));

        $this->pool->save($item);

        $repo = new MariaDbConfigRepository($this->mapper, $this->pool);
        $result = $repo->getConfig(self::EMPLOYER_ID, self::EMPLOYER_WORKING_TIME_ID);

        $config = new ConfigStub();
        TestCase::assertEquals($result->timeAccount, $config->timeAccount);
        TestCase::assertEquals($result->workingTime, $config->workingTime);
        TestCase::assertEquals($result->workingBreak, $config->workingBreak);
        TestCase::assertEquals($result->vacationDays, $config->vacationDays);
    }

    /**
     * @throws DatabaseException
     */
    public function test_getConfig_ExpectConfigFromRepo(): void
    {
        $pdo = new PdoStub();
        $pdo->setFetchAllReturnValue([MariaDbFetcher::getConfig()]);

        $repo = new MariaDbConfigRepository($this->mapper, $this->pool);
        $repo->setPdoDriver($pdo);

        $result = $repo->getConfig(self::EMPLOYER_ID, self::EMPLOYER_WORKING_TIME_ID);

        $config = new ConfigStub();
        TestCase::assertEquals($result->timeAccount, $config->timeAccount);
        TestCase::assertEquals($result->workingTime, $config->workingTime);
        TestCase::assertEquals($result->workingBreak, $config->workingBreak);
        TestCase::assertEquals($result->vacationDays, $config->vacationDays);
    }
}
