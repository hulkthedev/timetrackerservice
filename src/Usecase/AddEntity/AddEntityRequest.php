<?php

namespace App\Usecase\AddEntity;

use App\Usecase\EntityRequestInterface;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class AddEntityRequest implements EntityRequestInterface
{
    /** @var string */
    public $date;

    /** @var int */
    public $begin;
}
