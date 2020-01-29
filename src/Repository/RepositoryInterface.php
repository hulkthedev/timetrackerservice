<?php

namespace App\Repository;

use App\Entity\Day;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
interface RepositoryInterface
{
    public function getAll();

    public function get(Day $entity);

    /**
     * @param Day $entity
     */
    public function save(Day $entity);

    public function update(Day $entity);

    public function delete(Day $entity);
}