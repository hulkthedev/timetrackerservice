<?php

namespace App\Tests\Usecase\GetEntity;

use App\Repository\Mapper\MariaDbMapper;
use App\Tests\Repository\MariaDbFetcher;
use App\Usecase\BaseResponse;
use App\Usecase\GetEntity\GetEntityInteractor;
use App\Usecase\GetEntity\GetEntityRequest;
use App\Usecase\GetEntity\GetEntityResponse;
use App\Usecase\ResultCodes;
use Exception;
use Throwable;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class GetEntityInteractorStub extends GetEntityInteractor
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function execute(GetEntityRequest $request): BaseResponse
    {
        try {
            $entity = $this->getEntity();
        } catch (Throwable $throwable) {
            $entity = [];
        }

        return new GetEntityResponse(ResultCodes::SUCCESS, $entity);
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getEntity()
    {
        $entity = MariaDbFetcher::get();

        $mapper = new MariaDbMapper();
        return [$mapper->mapEntityToDay(reset($entity))];
    }
}
