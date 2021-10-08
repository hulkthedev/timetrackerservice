<?php

namespace App\Repository;

use App\Repository\Exception\DatabaseException;
use Exception;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
interface RepositoryInterface
{
    /**
     * @param int $employerId
     * @return array
     * @throws DatabaseException
     * @throws Exception
     */
    public function getAll(int $employerId): array;

    /**
     * @param string $date
     * @param int $employerId
     * @return array
     * @throws DatabaseException
     * @throws Exception
     */
    public function getByDate(string $date, int $employerId): array;

    /**
     * @param string $date
     * @param int $employerId
     * @param int $employerWorkingTimeId
     * @return array
     * @throws DatabaseException
     * @throws Exception
     */
    public function getById(string $date, int $employerId, int $employerWorkingTimeId): array;

    /**
     * @param string $date
     * @param int $employerId
     * @param int $employerWorkingTimeId
     * @return bool
     * @throws DatabaseException
     */
    public function delete(string $date, int $employerId, int $employerWorkingTimeId): bool;

    /**
     * @param string $date
     * @param int $employerId
     * @param int $employerWorkingTimeId
     * @param string $mode
     * @param int $beginTimestamp
     * @return bool
     * @throws DatabaseException
     */
    public function save(string $date, int $employerId, int $employerWorkingTimeId, string $mode, int $beginTimestamp): bool;

    /**
     * @param string $date
     * @param int $employerId
     * @param int $employerWorkingTimeId
     * @param string $mode
     * @param int $beginTimestamp
     * @param int $endTimestamp
     * @param int $break
     * @param int $delta
     * @return bool
     * @throws DatabaseException
     */
    public function update(string $date, int $employerId, int $employerWorkingTimeId, string $mode, int $beginTimestamp, int $endTimestamp, int $break, int $delta): bool;
}
