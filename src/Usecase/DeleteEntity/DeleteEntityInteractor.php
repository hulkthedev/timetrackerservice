<?php

namespace App\Usecase\DeleteEntity;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class DeleteEntityInteractor extends BaseInteractor
{
    /**
     * @param DeleteEntityRequest $request
     * @return BaseResponse
     */
    public function execute(DeleteEntityRequest $request): BaseResponse
    {
        try {
            $list = $this->repository->delete($request);
        } catch (DatabaseException $exception) {
            return $this->createUnsuccessfullyResponse($exception->getCode());
        } catch (\PDOException $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::PDO_EXCEPTION);
        } catch (\Throwable $throwable) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR);
        }

        return new DeleteEntityResponse(ResultCodes::SUCCESS, $list);
    }
}
