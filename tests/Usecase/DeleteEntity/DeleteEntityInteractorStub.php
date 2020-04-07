<?php

namespace App\Tests\Usecase\DeleteEntity;

use App\Usecase\BaseResponse;
use App\Usecase\DeleteEntity\DeleteEntityInteractor;
use App\Usecase\DeleteEntity\DeleteEntityRequest;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class DeleteEntityInteractorStub extends DeleteEntityInteractor
{
    public function __construct()
    {
    }

    public function execute(DeleteEntityRequest $request): BaseResponse
    {

    }
}
