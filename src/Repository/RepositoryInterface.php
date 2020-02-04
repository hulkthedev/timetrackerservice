<?php

namespace App\Repository;

use App\Repository\Exception\DatabaseException;
use App\Usecase\AddEntity\AddEntityRequest;
use App\Usecase\DeleteEntity\DeleteEntityRequest;
use App\Usecase\GetEntity\GetEntityRequest;
use App\Usecase\UpdateEntity\UpdateEntityRequest;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
interface RepositoryInterface
{
    /**
     * @return array
     * @throws DatabaseException
     */
    public function getAll(): array;

    /**
     * @param GetEntityRequest $request
     * @return array
     * @throws DatabaseException
     */
    public function get(GetEntityRequest $request): array;

    /**
     * @param AddEntityRequest $request
     * @return bool
     * @throws DatabaseException
     */
    public function save(AddEntityRequest $request): bool;

    /**
     * @param UpdateEntityRequest $request
     * @return bool
     * @throws DatabaseException
     */
    public function update(UpdateEntityRequest $request): bool;

    /**
     * @param DeleteEntityRequest $request
     * @return bool
     * @throws DatabaseException
     */
    public function delete(DeleteEntityRequest $request): bool;
}