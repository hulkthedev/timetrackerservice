<?php

namespace App\Tests\Usecase\AddEntity;

use App\Usecase\AddEntity\AddEntityInteractor;
use App\Usecase\AddEntity\AddEntityRequest;
use App\Usecase\AddEntity\AddEntityResponse;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class AddEntityInteractorStub extends AddEntityInteractor
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function execute(AddEntityRequest $request): BaseResponse
    {
        $response = new AddEntityResponse(ResultCodes::SUCCESS);
        $response->setHttpStatus(Response::HTTP_CREATED);
        $response->setHeaders(['Location' => "/{$request->date}"]);

        return $response;
    }
}
