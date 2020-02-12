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
     * @param $name
     * @param $arguments
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        throw new Exception('UnitTests');
    }

    /**
     * @inheritDoc
     */
    public function getAll(int $employerId): array
    {
    }

    /**
     * @inheritDoc
     */
    public function getByDate(string $date, int $employerId): array
    {
    }

    /**
     * @inheritDoc
     */
    public function getById(string $date, int $employerId, int $employerWorkingTimeId): array
    {
    }

    /**
     * @inheritDoc
     */
    public function delete(string $date, int $employerId, int $employerWorkingTimeId): bool
    {
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
    }
}
