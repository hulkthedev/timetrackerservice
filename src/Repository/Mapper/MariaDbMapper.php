<?php

namespace App\Repository\Mapper;

use App\Entity\Config;
use App\Entity\Day;
use App\Entity\Week;
use App\Usecase\BaseInteractor;
use DateTime;
use Exception;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class MariaDbMapper
{
    /**
     * @param array $list
     * @return Config
     */
    public function mapToConfig(array $list): Config
    {
        $config = new Config();
        $config->vacationDays = $list['vacation_days'];
        $config->workingTime = $list['working_time'];
        $config->workingBreak = $list['working_break'];
        $config->timeAccount = $list['time_account'];

        return $config;
    }

    /**
     * @param array $list
     * @return array
     * @throws Exception
     */
    public function mapToList(array $list): array
    {
        $days = [];
        foreach ($list as $entity) {
            $days[] = $this->mapEntityToDay($entity);
        }


        return $this->sort($days);
    }

    /**
     * @param array $entity
     * @return Day
     * @throws Exception
     */
    public function mapEntityToDay(array $entity): Day
    {
        $beginDateTime = new DateTime();
        $beginDateTime->setTimestamp($entity['begin_timestamp']);

        $endDateTime = new DateTime();
        $endDateTime->setTimestamp($entity['end_timestamp']);

        $day = new Day();
        $day->mode = $entity['mode'];
        $day->date = $entity['date'];
        $day->weekDay = $beginDateTime->format('N');
        $day->begin = $beginDateTime->format(BaseInteractor::DEFAULT_TIME_FORMAT);
        $day->end = $endDateTime->format(BaseInteractor::DEFAULT_TIME_FORMAT);
        $day->delta = $entity['delta'];
        $day->break = $entity['break'];

        $day->employerId = $entity['employer_id'];
        $day->employerName = $entity['employer_name'];

        $day->workingTimeId = $entity['employer_working_time_id'];
        $day->workingTimeDescription = $entity['working_time_description'];

        return $day;
    }

    /**
     * @param array $dayList
     * @return array
     * @throws Exception
     */
    private function sort(array $dayList): array
    {
        $daysByDate = [];

        /** @var Day $day */
        foreach ($dayList as $day) {
            $daysByDate[$day->date][] = $day;
        }

        $daysByWeek = [];

        /** @var Day $day */
        foreach ($daysByDate as $date => $days) {
            $weekNo = (int)(new DateTime($date))->format('W');
            $daysByWeek[$weekNo][] = $days;
        }

        $result = [];

        /** @var Day $day */
        foreach ($daysByWeek as $weekNo => $week) {
            $weekEntity = new Week();
            $weekEntity->weekNo = $weekNo;
            $weekEntity->weekDays = $week;
            $weekEntity->weekDelta = 0;

            $result[] = $weekEntity;
        }

        return $result;
    }
}
