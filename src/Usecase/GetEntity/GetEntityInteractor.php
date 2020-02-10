<?php

namespace App\Usecase\GetEntity;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use PDOException;
use Throwable;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
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
            $entity = ($request->employerWorkingTimeId > 0)
                ? $this->repository->getById($request->date, $request->employerId, $request->employerWorkingTimeId)
                : $this->repository->getByDate($request->date, $request->employerId);
        } catch (DatabaseException $exception) {
            return $this->createUnsuccessfullyResponse($exception->getCode());
        } catch (PDOException $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::PDO_EXCEPTION);
        } catch (Throwable $throwable) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR);
        }

        return new GetEntityResponse(ResultCodes::SUCCESS, $entity);
    }
}
