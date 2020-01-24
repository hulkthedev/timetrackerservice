<?php

namespace App\Usecase\ChangeEntity;

use App\Usecase\BaseInteractor;
use App\Usecase\BaseRequest;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class ChangeEntityInteractor extends BaseInteractor
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

        return new ChangeEntityResponse(ResultCodes::CODE_SUCCESS);
    }
}
