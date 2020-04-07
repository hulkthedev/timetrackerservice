<?php

namespace App\Tests\Usecase\AddEntity;

use App\Usecase\AddEntity\AddEntityInteractor;
use App\Usecase\AddEntity\AddEntityRequest;
use App\Usecase\BaseResponse;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class AddEntityInteractorStub extends AddEntityInteractor
{
    public function __construct()
    {
    }

    public function execute(AddEntityRequest $request): BaseResponse
    {

    }
}
