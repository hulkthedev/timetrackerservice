<?php

namespace App\Tests\Usecase\UpdateEntity;

use App\Usecase\BaseResponse;
use App\Usecase\UpdateEntity\UpdateEntityInteractor;
use App\Usecase\UpdateEntity\UpdateEntityRequest;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class UpdateEntityInteractorStub extends UpdateEntityInteractor
{
    public function __construct()
    {
    }

    public function execute(UpdateEntityRequest $request): BaseResponse
    {

    }
}
