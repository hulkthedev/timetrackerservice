<?php

namespace App\Repository;

use App\Entity\Day;
use App\Repository\Exception\EntityNotFoundException;

class FakeRepository implements RepositoryInterface
{
    private $entities = [];

    public function getAll()
    {
        return $this->entities;
    }

    /**
     * @inheritdoc
     */
    public function get(Day $entity)
    {
        if (isset($this->entities[$entity->date])) {
            return $this->entities[$entity->date];
        }

        throw new EntityNotFoundException();
    }

    /**
     * @inheritdoc
     */
    public function save(Day $entity)
    {
        $this->entities[$entity->date] = $entity;
        return $this->getAll();
    }

    /**
     * @inheritdoc
     */
    public function update(Day $entity)
    {
        if (isset($this->entities[$entity->date])) {
            return $this->save($entity);
        }

        throw new EntityNotFoundException();
    }

    /**
     * @inheritdoc
     */
    public function delete(Day $entity)
    {
        if (isset($this->entities[$entity->date])) {
            unset($this->entities[$entity->date]);
            return $this->getAll();
        }

        throw new EntityNotFoundException();
    }
}