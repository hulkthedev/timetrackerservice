<?php

namespace App\Repository;

use App\Entity\Day;
use App\Repository\Exception\EntityNotFoundException;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
interface RepositoryInterface
{
    public function getAll();

    /**
     * @param Day $entity
     * @throws EntityNotFoundException
     */
    public function get(Day $entity);

    /**
     * @param Day $entity
     */
    public function save(Day $entity);

    /**
     * @param Day $entity
     * @throws EntityNotFoundException
     */
    public function update(Day $entity);

    /**
     * @param Day $entity
     * @throws EntityNotFoundException
     */
    public function delete(Day $entity);
}