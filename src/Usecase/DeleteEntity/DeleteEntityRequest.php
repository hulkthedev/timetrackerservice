<?php

namespace App\Usecase\DeleteEntity;

use App\Usecase\EntityRequestInterface;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class DeleteEntityRequest implements EntityRequestInterface
{
    /** @var string */
    public $date;
}
