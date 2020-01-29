<?php

namespace App\Repository;

use App\Entity\Day;

class FakeRepository implements RepositoryInterface
{

    public function getAll()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function get(Day $entity)
    {
        return [$entity];
    }

    /**
     * @inheritdoc
     */
    public function save(Day $entity)
    {
        return [$entity];
    }

    /**
     * @inheritdoc
     */
    public function update(Day $entity)
    {
        return [$entity];
    }

    /**
     * @inheritdoc
     */
    public function delete(Day $entity)
    {
        return [$entity];
    }
}