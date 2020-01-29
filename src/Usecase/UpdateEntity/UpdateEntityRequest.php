<?php

namespace App\Usecase\UpdateEntity;

use App\Usecase\BaseRequest;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class UpdateEntityRequest extends BaseRequest
{
    /** @var int */
    public $begin;

    /** @var int */
    public $end;

    /** @var string */
    public $mode;


}
