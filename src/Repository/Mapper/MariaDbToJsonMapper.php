<?php

namespace App\Repository\Mapper;

use App\Entity\Day;
use App\Entity\Week;
use App\Usecase\BaseInteractor;
use DateTime;
use Exception;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class MariaDbToJsonMapper
{
    /**
     * @param array $list
     * @return array
     * @throws Exception
     */
    public function mapToList(array $list): array
    {
        $days = [];
        foreach ($list as $entity) {
            $days[] = $this->createDayFromEntity($entity);
        }

        return $this->sort($days);
    }

    /**
     * @param array $entity
     * @return Day
     * @throws Exception
     */
    public function mapToDay(array $entity): Day
    {
        return $this->createDayFromEntity($entity);
    }

    /**
     * @param array $entity
     * @return Day
     * @throws Exception
     */
    private function createDayFromEntity(array $entity): Day
    {
        $beginDateTime = new DateTime();
        $beginDateTime->setTimestamp($entity['begin_timestamp']);

        $endDateTime = new DateTime();
        $endDateTime->setTimestamp($entity['end_timestamp']);

        $day = new Day();
        $day->mode = $entity['mode'];
        $day->date = $entity['date'];
        $day->number = $beginDateTime->format('N');
        $day->begin = $beginDateTime->format(BaseInteractor::DEFAULT_TIME_FORMAT);
        $day->end = $endDateTime->format(BaseInteractor::DEFAULT_TIME_FORMAT);

        return $day;
    }

    /**
     * @param array $list
     * @return array
     * @throws Exception
     */
    private function sort(array $list): array
    {
        $groupedDays = [];

        /** @var Day $day */
        foreach ($list as $day) {
            $weekNo = (new DateTime($day->date))->format('W');
            $groupedDays[(int)$weekNo][] = $day;
        }

        $result = [];

        /** @var Day $day */
        foreach ($groupedDays as $weekNo => $week) {
            $weekEntity = new Week();
            $weekEntity->weekNo = $weekNo;
            $weekEntity->weekDays = $week;

            $result[] = $weekEntity;
        }

        return $result;
    }
}
