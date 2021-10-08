<?php

namespace App\Tests\Usecase\DeleteEntity;

use App\Usecase\DeleteEntity\DeleteEntityRequest;

/**
 * @author ~albei <fatal.error.27@gmail.com>
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
