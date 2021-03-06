<?php

namespace App\Usecase\GetAllEntities;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use PDOException;
use Throwable;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class GetAllEntitiesInteractor extends BaseInteractor
{
    /**
     * @param GetAllEntitiesRequest $request
     * @return BaseResponse
     */
    public function execute(GetAllEntitiesRequest $request): BaseResponse
    {
        try {
            $list = $this->repository->getAll($request->employerId);
        } catch (DatabaseException $exception) {
            return $this->createUnsuccessfullyResponse($exception->getCode());
        } catch (Throwable $throwable) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR);
        }

        return new GetAllEntitiesResponse(ResultCodes::SUCCESS, $list);
    }
}
