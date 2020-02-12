<?php

namespace App\Tests\Repository;

use App\Repository\RepositoryInterface;
use PDOException;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class MariaDbTrackingRepositoryPDOExceptionStub implements RepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAll(int $employerId): array
    {
        throw new PDOException('UnitTests');
    }

    /**
     * @inheritDoc
     */
    public function getByDate(string $date, int $employerId): array
    {
        throw new PDOException('UnitTests');
    }

    /**
     * @inheritDoc
     */
    public function getById(string $date, int $employerId, int $employerWorkingTimeId): array
    {
        throw new PDOException('UnitTests');
    }

    /**
     * @inheritDoc
     */
    public function delete(string $date, int $employerId, int $employerWorkingTimeId): bool
    {
        throw new PDOException('UnitTests');
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
        throw new PDOException('UnitTests');
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
        throw new PDOException('UnitTests');
    }
}
