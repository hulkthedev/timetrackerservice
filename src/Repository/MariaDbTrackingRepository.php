<?php

namespace App\Repository;

use App\Repository\Exception\DatabaseException;
use App\Usecase\ResultCodes;
use PDO;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class MariaDbTrackingRepository extends MariaDbBaseRepository implements RepositoryInterface
{
    private const CACHE_KEY_PREFIX = 'working_times_';
    private const STORED_PROCEDURE_SAVE = 'CALL SaveEntity(:employerId, :employerWorkingTimeId, :date, :mode, :begin_timestamp)';
    private const STORED_PROCEDURE_UPDATE = 'CALL UpdateEntity(:employerId, :employerWorkingTimeId, :date, :mode, :begin_timestamp, :end_timestamp, :break, :delta)';
    private const STORED_PROCEDURE_DELETE = 'CALL DeleteEntity(:employerId, :employerWorkingTimeId, :date)';
    private const STORED_PROCEDURE_GET_ALL = 'CALL GetAllEntities(:employerId)';
    private const STORED_PROCEDURE_GET_BY_ID = 'CALL GetEntityById(:employerId, :employerWorkingTimeId, :date)';
    private const STORED_PROCEDURE_GET_BY_DATE = 'CALL GetEntityByDate(:employerId, :date)';

    /**
     * @inheritDoc
     */
    public function getAll(int $employerId): array
    {
        $key = self::CACHE_KEY_PREFIX . "{$employerId}";
        if (false !== $list = $this->getFromCache($key)) {
            return $list;
        }

        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_GET_ALL);
        $statement->execute(['employerId' => $employerId]);

        $unmappedList = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($unmappedList)) {
            throw new DatabaseException(ResultCodes::DATABASE_IS_EMPTY);
        }

        $list = $this->getMapper()->mapToList($unmappedList);
        $this->storeInCache($key, $list);

        return $list;
    }

    /**
     * @inheritDoc
     */
    public function getByDate(string $date, int $employerId): array
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_GET_BY_DATE);
        $statement->execute([
            'date' => $date,
            'employerId' => $employerId
        ]);

        $entity = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($entity)) {
            throw new DatabaseException(ResultCodes::ENTITY_NOT_FOUND);
        }

        return $this->getMapper()->mapToList($entity);
    }

    /**
     * @inheritDoc
     */
    public function getById(string $date, int $employerId, int $employerWorkingTimeId): array
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_GET_BY_ID);
        $statement->execute([
            'date' => $date,
            'employerId' => $employerId,
            'employerWorkingTimeId' => $employerWorkingTimeId
        ]);

        $entity = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($entity)) {
            throw new DatabaseException(ResultCodes::ENTITY_NOT_FOUND);
        }

        return [$this->getMapper()->mapEntityToDay(reset($entity))];
    }

    /**
     * @inheritDoc
     */
    public function delete(string $date, int $employerId, int $employerWorkingTimeId): bool
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_DELETE);
        $result = $statement->execute([
            'date' => $date,
            'employerId' => $employerId,
            'employerWorkingTimeId' => $employerWorkingTimeId
        ]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_DELETED);
        }

        $key = self::CACHE_KEY_PREFIX . "{$employerId}";
        $this->clearCacheByKey($key);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function save(string $date, int $employerId, int $employerWorkingTimeId, string $mode, int $beginTimestamp): bool
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_SAVE);
        $result = $statement->execute([
            'date' => $date,
            'employerId' => $employerId,
            'employerWorkingTimeId' => $employerWorkingTimeId,
            'mode' => $mode,
            'begin_timestamp' => $beginTimestamp
        ]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_SAVED);
        }

        $key = self::CACHE_KEY_PREFIX . "{$employerId}";
        $this->clearCacheByKey($key);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function update(string $date, int $employerId, int $employerWorkingTimeId, string $mode, int $beginTimestamp, int $endTimestamp, int $break, int $delta): bool
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_UPDATE);
        $result = $statement->execute([
            'date' => $date,
            'employerId' => $employerId,
            'employerWorkingTimeId' => $employerWorkingTimeId,
            'mode' => $mode,
            'begin_timestamp' => $beginTimestamp,
            'end_timestamp' => $endTimestamp,
            'break' => $break,
            'delta' => $delta
        ]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_UPDATED);
        }

        $key = self::CACHE_KEY_PREFIX . "{$employerId}";
        $this->clearCacheByKey($key);

        return true;
    }
}
