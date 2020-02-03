<?php

namespace App\Usecase\GetEntity;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class GetEntityInteractor extends BaseInteractor
{
    /**
     * @param GetEntityRequest $request
     * @return BaseResponse
     */
    public function execute(GetEntityRequest $request): BaseResponse
    {
        try {
            $list = $this->repository->get($request);
        } catch (DatabaseException $exception) {
            return $this->createUnsuccessfullyResponse($exception->getCode());
        } catch (\PDOException $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::PDO_EXCEPTION);
        } catch (\Throwable $throwable) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR);
        }

        return new GetEntityResponse(ResultCodes::SUCCESS, $list);
    }
}
