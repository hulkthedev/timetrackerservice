<?php

namespace App\Tests\Service;

use App\Service\CalculationService;
use App\Tests\Entity\ConfigStub;
use PHPUnit\Framework\TestCase;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class CalculationServiceTest extends TestCase
{
    /**
     * @return array
     */
    public function dateTimeDataProviderForDefaultWorkingDay(): array
    {
        return [
            /** 08:00-16:12 = 492min - 30min break = 462min - 462min should work time = 0min overtime  */
            [1582012800, 1582042320, 30, 0],
            /** 08:00-16:27 = 507min - 30min break = 477min - 462min should work time = 15min overtime */
            [1582012800, 1582043220, 30, 15],
            /** 08:00-16:00 = 480min - 30min break = 450min - 462min should work time = -12min overtime */
            [1582012800, 1582041600, 30, -12],

            /** 08:00-13:59 = 359min (under 6h working time = 0min break!!!) - 0min break = 359min - 462min should work time = -103min overtime */
            [1582012800, 1582034340, 0, -103],
            /** 08:00-14:01 = 361min (over 6h working time = 30min break!!!) - 30min break = 331min - 462min should work time = -131 Minutes overtime */
            [1582012800, 1582034460, 150, -131],

            /** 08:00-18:00 = 600min (over 9h working time = 45min break!!!) - 45min = 555min - 462min should work time = 93min overtime */
            [1582012800, 1582048800, 30, 93],
            /** 08:00-18:00 + 600min (over 9h working time = 45min break!!!) - 60min = 540min - 462min should work time = 78 Minutes overtime */
            [1582012800, 1582048800, 60, 78]
        ];
    }

    /**
     * @dataProvider dateTimeDataProviderForDefaultWorkingDay
     * @param int $beginTimestamp
     * @param int $endTimestamp
     * @param int $break
     * @param int $expectedResult
     */
    public function test_calculateDelta_expectRightCalculation(
        int $beginTimestamp,
        int $endTimestamp,
        int $break,
        int $expectedResult
    ): void {
        $calculationService = new CalculationService();
        $calculationService->setConfig(new ConfigStub()); // 7:42h per day + 30 Min. break

        $delta = $calculationService->calculateDelta($beginTimestamp, $endTimestamp, $break);
        TestCase::assertEquals($delta, $expectedResult);
    }
}
