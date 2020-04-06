<?php

namespace App\Repository\Mapper;

use App\Entity\Config;
use App\Entity\Day;
use App\Entity\Week;
use App\Usecase\BaseInteractor;
use DateTime;
use Exception;

/**
 * @author ~albei <fatal.error.27@gmail.com>
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
//        if ($entity['begin_timestamp'] === '0') {
//            $beginDateTime = new DateTime($entity['date']);
//        } else {
            $beginDateTime = new DateTime();
            $beginDateTime->setTimestamp($entity['begin_timestamp']);
//        }

        $endDateTime = new DateTime();
        $endDateTime->setTimestamp($entity['end_timestamp']);

        $day = new Day();
        $day->mode = $entity['mode'];
        $day->date = $entity['date'];
        $day->weekday = $beginDateTime->format('N');
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
        $daysByWeek = [];

        /** @var Day $day */
        foreach ($dayList as $day) {
            $weekNo = (int)(new DateTime($day->date))->format('W');
            $daysByWeek[$weekNo][] = $day;
        }

        $result = [];

        /** @var Day $day */
        foreach ($daysByWeek as $weekNo => $week) {
            $weekEntity = new Week();
            $weekEntity->no = $weekNo;
            $weekEntity->days = $week;
            $weekEntity->delta = $this->calculateWeekDelta($week);
            $weekEntity->deltaFormatted = $this->getFormattedWeekDelta($weekEntity->delta);

            $result[] = $weekEntity;
        }

        return $result;
    }

    /**
     * @param array $week
     * @return int
     */
    private function calculateWeekDelta(array $week): int
    {
        $delta = 0;
        foreach ($week as $day) {
            $delta += $day->delta;
        }

        return $delta;
    }

    /**
     * @param int $delta
     * @return string
     */
    private function getFormattedWeekDelta(int $delta): string
    {
        $operator = '';
        if ($delta < 0) {
            $operator = '-';
            $delta *= -1;
        }

        $hours = str_pad(floor($delta / 60), 2, '0', STR_PAD_LEFT);
        $minutes = str_pad(($delta % 60), 2, '0', STR_PAD_LEFT);

        return "{$operator}{$hours}:{$minutes}";
    }
}
