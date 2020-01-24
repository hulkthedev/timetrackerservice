<?php

namespace App\Usecase\DeleteEntity;

use App\Usecase\BaseInteractor;
use App\Usecase\BaseRequest;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class DeleteEntityInteractor extends BaseInteractor
{
    /**
     * @param BaseRequest $request
     * @return BaseResponse
     */
    public function execute(BaseRequest $request): BaseResponse
    {
        try {

        } catch (\Exception $exception) {

        }

        return new DeleteEntityResponse(ResultCodes::CODE_SUCCESS);
    }
}
