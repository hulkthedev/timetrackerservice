<?php

namespace App\Usecase\AddMultiEntities;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class AddMultiEntitiesRequest
{
    public string $fromDate;
    public string $toDate;
    public string $mode;
    public int $begin;
}
