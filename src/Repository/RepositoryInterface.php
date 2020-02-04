<?php

namespace App\Repository;

use App\Repository\Exception\DatabaseException;
use App\Usecase\AddEntity\AddEntityRequest;
use App\Usecase\DeleteEntity\DeleteEntityRequest;
use App\Usecase\GetEntity\GetEntityRequest;
use App\Usecase\UpdateEntity\UpdateEntityRequest;
use Exception;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
interface RepositoryInterface
{
    /**
     * @return array
     * @throws DatabaseException
     * @throws Exception
     */
    public function getAll(): array;

    /**
     * @param GetEntityRequest $request
     * @return array
     * @throws DatabaseException
     * @throws Exception
     */
    public function get(GetEntityRequest $request): array;

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