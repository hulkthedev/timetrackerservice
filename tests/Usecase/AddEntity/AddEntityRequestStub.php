<?php

namespace App\Tests\Usecase\AddEntity;

use App\Usecase\AddEntity\AddEntityRequest;
use App\Usecase\Modes;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class AddEntityRequestStub extends AddEntityRequest
{
    public function __construct()
    {
        $this->date = '2020-01-06';
        $this->employerId = 1;
        $this->employerWorkingTimeId = 1;

        $this->mode = Modes::MODE_WORKING;
        $this->begin = 1579080900;
        $this->break = 30;
    }
}
