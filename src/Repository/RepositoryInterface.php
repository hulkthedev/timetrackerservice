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
     * @return array
     * @throws DatabaseException
     */
    public function save(AddEntityRequest $request): array;

    /**
     * @param UpdateEntityRequest $request
     * @return array
     * @throws DatabaseException
     */
    public function update(UpdateEntityRequest $request): array;

    /**
     * @param DeleteEntityRequest $request
     * @return array
     * @throws DatabaseException
     */
    public function delete(DeleteEntityRequest $request): array;
}