<?php

namespace App\Repository;

use App\Repository\Exception\DatabaseException;
use App\Usecase\AddEntity\AddEntityRequest;
use App\Usecase\DeleteEntity\DeleteEntityRequest;
use App\Usecase\UpdateEntity\UpdateEntityRequest;
use Exception;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
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
     * @param AddEntityRequest $request
     * @throws DatabaseException
     */
    public function save(AddEntityRequest $request): void;

    /**
     * @param UpdateEntityRequest $request
     * @throws DatabaseException
     */
    public function update(UpdateEntityRequest $request): void;

    /**
     * @param DeleteEntityRequest $request
     * @throws DatabaseException
     */
    public function delete(DeleteEntityRequest $request): void;
}