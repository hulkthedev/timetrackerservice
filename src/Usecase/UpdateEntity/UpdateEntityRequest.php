<?php

namespace App\Usecase\UpdateEntity;

use App\Usecase\BaseRequest;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class UpdateEntityRequest extends BaseRequest
{
    public int $begin;
    public int $end;
    public string $mode;
}
