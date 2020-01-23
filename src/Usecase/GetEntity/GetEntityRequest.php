<?php

namespace App\Usecase\GetEntity;

use App\Usecase\EntityRequestInterface;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class GetEntityRequest implements EntityRequestInterface
{
    /** @var string */
    public $date;
}
