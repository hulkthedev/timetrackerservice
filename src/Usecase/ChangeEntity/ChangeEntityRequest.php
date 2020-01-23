<?php

namespace App\Usecase\ChangeEntity;

use App\Usecase\EntityRequestInterface;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class ChangeEntityRequest implements EntityRequestInterface
{
    /** @var string */
    public $date;
}
