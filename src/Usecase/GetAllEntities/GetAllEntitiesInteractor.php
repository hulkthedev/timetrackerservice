<?php

namespace App\Usecase\GetAllEntities;

use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use PDOException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class GetAllEntitiesInteractor extends BaseInteractor
{
    /**
     * @return BaseResponse
     */
    public function execute(): BaseResponse
    {
        try {
            $list = $this->repository->getAll();
        } catch (PDOException $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::PDO_EXCEPTION, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new GetAllEntitiesResponse(ResultCodes::SUCCESS, $list);
    }
}
