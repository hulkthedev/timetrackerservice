<?php

namespace App\Tests\Usecase\GetEntity;

use App\Usecase\GetEntity\GetEntityRequest;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class GetEntityRequestStub extends GetEntityRequest
{
    public function __construct()
    {
        $this->date = '2020-01-06';
        $this->employerId = 1;
        $this->employerWorkingTimeId = 1;
    }
}
