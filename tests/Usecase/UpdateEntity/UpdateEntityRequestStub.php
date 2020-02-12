<?php

namespace App\Tests\Usecase\UpdateEntity;

use App\Usecase\Modes;
use App\Usecase\UpdateEntity\UpdateEntityRequest;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class UpdateEntityRequestStub extends UpdateEntityRequest
{
    public function __construct()
    {
        $this->date = '2020-01-06';
        $this->employerId = 1;
        $this->employerWorkingTimeId = 1;

        $this->mode = Modes::MODE_VACATION;
        $this->begin = 0;
        $this->end = 0;
        $this->break = 0;
    }
}
