<?php

namespace App\Tests\Repository\Mapper;

use App\Entity\Day;
use App\Entity\Week;
use App\Repository\Mapper\MariaDbMapper;
use App\Tests\Repository\MariaDbFetcher;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class MariaDbMapperTest extends TestCase
{
    private MariaDbMapper $mapper;

    protected function setUp(): void
    {
        $this->mapper = new MariaDbMapper();
    }

    /**
     * @throws Exception
     */
    public function test_mapToList_expectRightDataMapping(): void
    {
        $result = $this->mapper->mapToList(MariaDbFetcher::getAll());

        /** @var Week $week */
        $week = reset($result);
        TestCase::assertInstanceOf(Week::class, $week);
        TestCase::assertInstanceOf(Day::class, $week->days[0]);
        TestCase::assertEquals(5, count($week->days));
        TestCase::assertEquals(2, $week->no);
        TestCase::assertEquals(63, $week->delta);
        TestCase::assertEquals('01:03', $week->deltaFormatted);
    }
}