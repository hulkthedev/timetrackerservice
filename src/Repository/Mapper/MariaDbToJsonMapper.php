<?php

namespace App\Repository\Mapper;

use App\Entity\Day;
use App\Repository\Exception\DatabaseException;
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
     * @throws DatabaseException
     * @throws Exception
     */
    public function map(array $list): array
    {
        $mappedList = [];
        foreach ($list as $index => $entity) {
            $day = $this->createDayFromEntity($entity);
            $mappedList[] = $day;
        }

        return $mappedList;
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
        $day->id = $entity['id'];
        $day->mode = $entity['mode'];
        $day->date = $entity['date'];
        $day->begin = $beginDateTime->format(BaseInteractor::DEFAULT_TIME_FORMAT);
        $day->end = $endDateTime->format(BaseInteractor::DEFAULT_TIME_FORMAT);
        $day->delta = (int)$entity['delta'];

        return $day;
    }

    /**
     * @param array $list
     * @return array
     */
    private function sortByWeek(array $list): array
    {
        return [];
    }
}
