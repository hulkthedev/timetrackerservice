<?php

namespace App\Tests\Repository;

use App\Repository\Exception\DatabaseException;
use App\Repository\RepositoryInterface;
use App\Usecase\ResultCodes;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class MariaDbTrackingRepositoryDatabaseExceptionStub implements RepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAll(int $employerId): array
    {
        throw new DatabaseException(ResultCodes::DATABASE_IS_EMPTY);
    }

    /**
     * @inheritDoc
     */
    public function getByDate(string $date, int $employerId): array
    {
        throw new DatabaseException(ResultCodes::ENTITY_NOT_FOUND);
    }

    /**
     * @inheritDoc
     */
    public function getById(string $date, int $employerId, int $employerWorkingTimeId): array
    {
        throw new DatabaseException(ResultCodes::ENTITY_NOT_FOUND);
    }

    /**
     * @inheritDoc
     */
    public function delete(string $date, int $employerId, int $employerWorkingTimeId): bool
    {
        throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_DELETED);
    }

    /**
     * @inheritDoc
     */
    public function save(
        string $date,
        int $employerId,
        int $employerWorkingTimeId,
        string $mode,
        int $beginTimestamp
    ): bool {
        throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_SAVED);
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
        throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_UPDATED);
    }
}
