<?php

namespace App\Repository\Mapper;

use App\Entity\Day;
use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\ResultCodes;
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
        $this->validate($list);

        $mappedList = [];
        foreach ($list as $index => $entity) {
            $day = $this->createDayFromEntity($entity);
            $mappedList[] = $day;
        }

        return $mappedList;
    }

    /**
     * @param array $list
     * @throws DatabaseException
     */
    private function validate(array $list): void
    {
        if (empty($list)) {
            throw new DatabaseException(ResultCodes::DATABASE_IS_EMPTY);
        }
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

//        $endDateTime = new DateTime();
//        $endDateTime->setTimestamp($entity['end_timestamp']);

        $day = new Day();
        $day->id = $entity['id'];
        $day->mode = $entity['mode'];
        $day->date = $entity['date'];
        $day->begin = $entity['begin_timestamp'];
        $day->end = $entity['end_timestamp'];
        $day->delta = $entity['delta'];

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
