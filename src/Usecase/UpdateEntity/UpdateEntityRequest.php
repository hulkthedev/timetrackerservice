<?php

namespace App\Usecase\UpdateEntity;

use App\Usecase\BaseRequest;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class UpdateEntityRequest extends BaseRequest
{
    public string $mode;
    public int $begin;
    public int $end;
    public int $break;
}
