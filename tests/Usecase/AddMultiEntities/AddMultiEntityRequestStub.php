<?php

namespace App\Tests\Usecase\AddMultiEntities;

use App\Usecase\AddMultiEntities\AddMultiEntitiesRequest;
use App\Usecase\Modes;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class AddMultiEntityRequestStub extends AddMultiEntitiesRequest
{
    public function __construct()
    {
        $this->date = '2020-01-06';
        $this->toDate = '2020-01-08';
        $this->employerId = 1;
        $this->employerWorkingTimeId = 1;

        $this->mode = Modes::MODE_VACATION;
        $this->begin = 0;
        $this->break = 0;
    }
}
