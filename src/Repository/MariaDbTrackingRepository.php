<?php

namespace App\Repository;

use App\Cache\CacheItem;
use App\Repository\Exception\DatabaseException;
use App\Usecase\ResultCodes;
use PDO;
use Psr\Cache\InvalidArgumentException;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class MariaDbTrackingRepository extends MariaDbBaseRepository implements RepositoryInterface
{
    private const STORED_PROCEDURE_SAVE = 'CALL SaveEntity(:employerId, :employerWorkingTimeId, :date, :mode, :begin_timestamp)';
    private const STORED_PROCEDURE_UPDATE = 'CALL UpdateEntity(:employerId, :employerWorkingTimeId, :date, :mode, :begin_timestamp, :end_timestamp, :break, :delta)';
    private const STORED_PROCEDURE_DELETE = 'CALL DeleteEntity(:employerId, :employerWorkingTimeId, :date)';
    private const STORED_PROCEDURE_GET_ALL = 'CALL GetAllEntities(:employerId)';
    private const STORED_PROCEDURE_GET_BY_ID = 'CALL GetEntityById(:employerId, :employerWorkingTimeId, :date)';
    private const STORED_PROCEDURE_GET_BY_DATE = 'CALL GetEntityByDate(:employerId, :date)';

    private const COLUMN_DATE = 'date';
    private const COLUMN_MODE = 'mode';
    private const COLUMN_BREAK = 'break';
    private const COLUMN_DELTA = 'delta';
    private const COLUMN_END_TIMESTAMP = 'end_timestamp';
    private const COLUMN_BEGIN_TIMESTAMP = 'begin_timestamp';
    private const COLUMN_EMPLOYER_ID = 'employerId';
    private const COLUMN_EMPLOYER_WORKING_TIME_ID = 'employerWorkingTimeId';

    /**
     * @inheritDoc
     */
    public function getAll(int $employerId): array
    {
        $key = CacheItem::PREFIX_WORKING_TIME . $employerId;
        if (false !== $list = $this->getFromCachePool($key)) {
            return $list;
        }

        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_GET_ALL);
        $statement->execute([self::COLUMN_EMPLOYER_ID => $employerId]);

        $unmappedList = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($unmappedList)) {
            throw new DatabaseException(ResultCodes::DATABASE_IS_EMPTY);
        }

        $list = $this->getMapper()->mapToList($unmappedList);
        $this->saveInCachePool($key, $list);

        return $list;
    }

    /**
     * @inheritDoc
     */
    public function getByDate(string $date, int $employerId): array
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_GET_BY_DATE);
        $statement->execute([
            self::COLUMN_DATE => $date,
            self::COLUMN_EMPLOYER_ID => $employerId
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
            self::COLUMN_DATE => $date,
            self::COLUMN_EMPLOYER_ID=> $employerId,
            self::COLUMN_EMPLOYER_WORKING_TIME_ID => $employerWorkingTimeId
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
            self::COLUMN_DATE => $date,
            self::COLUMN_EMPLOYER_ID => $employerId,
            self::COLUMN_EMPLOYER_WORKING_TIME_ID => $employerWorkingTimeId
        ]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_DELETED);
        }

        try {
            $key = CacheItem::PREFIX_WORKING_TIME . $employerId;
            $this->deleteFromCachePool($key);
        } catch (InvalidArgumentException $exception) {
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function save(string $date, int $employerId, int $employerWorkingTimeId, string $mode, int $beginTimestamp): bool
    {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_SAVE);
        $result = $statement->execute([
            self::COLUMN_DATE => $date,
            self::COLUMN_EMPLOYER_ID => $employerId,
            self::COLUMN_EMPLOYER_WORKING_TIME_ID => $employerWorkingTimeId,
            self::COLUMN_MODE => $mode,
            self::COLUMN_BEGIN_TIMESTAMP => $beginTimestamp
        ]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_SAVED);
        }

        try {
            $key = CacheItem::PREFIX_WORKING_TIME . $employerId;
            $this->deleteFromCachePool($key);
        } catch (InvalidArgumentException $exception) {
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function update(
        string $date,
        int $employerId,
        int $employerWorkingTimeId,
        string $mode,
        int $beginTimestamp,
        int $endTimestamp,
        int $break,
        int $delta
    ): bool {
        $statement = $this->getPdoDriver()->prepare(self::STORED_PROCEDURE_UPDATE);
        $result = $statement->execute([
            self::COLUMN_DATE => $date,
            self::COLUMN_EMPLOYER_ID => $employerId,
            self::COLUMN_EMPLOYER_WORKING_TIME_ID => $employerWorkingTimeId,
            self::COLUMN_MODE => $mode,
            self::COLUMN_BEGIN_TIMESTAMP => $beginTimestamp,
            self::COLUMN_END_TIMESTAMP => $endTimestamp,
            self::COLUMN_BREAK => $break,
            self::COLUMN_DELTA=> $delta
        ]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_UPDATED);
        }

        try {
            $key = CacheItem::PREFIX_WORKING_TIME . $employerId;
            $this->deleteFromCachePool($key);
        } catch (InvalidArgumentException $exception) {
        }

        return true;
    }
}
