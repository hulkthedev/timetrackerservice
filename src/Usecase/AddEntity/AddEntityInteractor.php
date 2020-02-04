<?php

namespace App\Usecase\AddEntity;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class AddEntityInteractor extends BaseInteractor
{
    /**
     * @param AddEntityRequest $request
     * @return BaseResponse
     */
    public function execute(AddEntityRequest $request): BaseResponse
    {
        try {
            $this->repository->save($request);
        } catch (DatabaseException $exception) {
            return $this->createUnsuccessfullyResponse($exception->getCode());
        } catch (\PDOException $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::PDO_EXCEPTION);
        } catch (\Throwable $throwable) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR);
        }

        return new AddEntityResponse(ResultCodes::SUCCESS);
    }
}
