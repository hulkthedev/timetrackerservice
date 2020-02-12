<?php

namespace App\Tests\Usecase\DeleteEntity;

use App\Usecase\AddMultiEntities\AddMultiEntitiesRequest;
use App\Usecase\DeleteEntity\DeleteEntityRequest;
use App\Usecase\Modes;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class DeleteEntityRequestStub extends DeleteEntityRequest
{
    public function __construct()
    {
        $this->date = '2020-01-06';
        $this->employerId = 1;
        $this->employerWorkingTimeId = 1;
    }
}
