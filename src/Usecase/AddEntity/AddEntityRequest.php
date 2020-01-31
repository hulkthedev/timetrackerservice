<?php

namespace App\Usecase\AddEntity;

use App\Usecase\BaseRequest;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class AddEntityRequest extends BaseRequest
{
    public int $begin;
    public string $mode;
}
