<?php

namespace App\Usecase\AddMultiEntities;

use App\Usecase\BaseRequest;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class AddMultiEntitiesRequest extends BaseRequest
{
    public string $toDate;
    public string $mode;
    public int $begin;
    public int $break;
}
