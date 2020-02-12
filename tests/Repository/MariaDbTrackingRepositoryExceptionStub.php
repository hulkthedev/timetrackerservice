<?php

namespace App\Tests\Repository;

use App\Repository\RepositoryInterface;
use Exception;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class MariaDbTrackingRepositoryExceptionStub implements RepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAll(int $employerId): array
    {
        throw new Exception('UnitTests');
    }

    /**
     * @inheritDoc
     */
    public function getByDate(string $date, int $employerId): array
    {
        throw new Exception('UnitTests');
    }

    /**
     * @inheritDoc
     */
    public function getById(string $date, int $employerId, int $employerWorkingTimeId): array
    {
        throw new Exception('UnitTests');
    }

    /**
     * @inheritDoc
     */
    public function delete(string $date, int $employerId, int $employerWorkingTimeId): bool
    {
        throw new Exception('UnitTests');
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
        throw new Exception('UnitTests');
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
        throw new Exception('UnitTests');
    }
}
