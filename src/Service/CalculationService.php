<?php

namespace App\Service;

use App\Entity\Config;
use DateTime;
use Throwable;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class CalculationService
{
    private const SHORT_WORKING_DAY_IN_MINUTES = 360;
    private const SHORT_WORKING_DAY_BREAK = 0;

    private const LONG_WORKING_DAY_IN_MINUTES = 540;
    private const LONG_WORKING_DAY_BREAK = 45;

    private Config $config;

    /**
     * @param Config $config
     * @return CalculationService
     */
    public function setConfig(Config $config): CalculationService
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @param int $beginTimestamp
     * @param int $endTimestamp
     * @param int $break
     * @return int
     */
    public function calculateDelta(int $beginTimestamp, int $endTimestamp, int $break): int
    {
        try {
            $beginDateTime = new DateTime();
            $beginDateTime->setTimestamp($beginTimestamp);

            $endDateTime = new DateTime();
            $endDateTime->setTimestamp($endTimestamp);

            /** calculate delta between begin and end */
            $timeInterval = $beginDateTime->diff($endDateTime);
            $deltaInMinutes = ($timeInterval->h * 60) + $timeInterval->i;

            /** subtract breaking time from delta */
            $break = $this->getBreakTimeByDuration($deltaInMinutes, $break);
            $deltaInMinutes -= $break;

            /** calculate overtime */
            $deltaInMinutes -= $this->config->workingTime;
        } catch (Throwable $throwable) {
            return 0;
        }

        return $deltaInMinutes;
    }

    /**
     * @param int $break
     * @param int $workingTime
     * @return int
     */
    private function getBreakTimeByDuration(int $workingTime, int $break): int
    {
        if ($workingTime < self::SHORT_WORKING_DAY_IN_MINUTES) {
            $break = $break > self::SHORT_WORKING_DAY_BREAK ? $break : self::SHORT_WORKING_DAY_BREAK;
        } elseif ($workingTime > self::LONG_WORKING_DAY_IN_MINUTES) {
            $break = $break > self::LONG_WORKING_DAY_BREAK ? $break : self::LONG_WORKING_DAY_BREAK;
        } elseif ($this->config->workingBreak > $break) {
            $break = $this->config->workingBreak;
        }

        return $break;
    }
}
