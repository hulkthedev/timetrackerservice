<?php

namespace App\Service;

use App\Entity\Config;
use DateTime;
use Exception;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class CalculationService
{
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
     * @throws Exception
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
            $break = ($this->config->workingBreak >= $break)
                ? $this->config->workingBreak
                : $break;

            $deltaInMinutes -= $break;

            /** calculate overtime */
            $deltaInMinutes -= $this->config->workingTime;
        } catch (\Throwable $throwable) {
            return 0;
        }

        return $deltaInMinutes;
    }
}
