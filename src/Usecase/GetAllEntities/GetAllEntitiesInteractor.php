<?php

namespace App\Usecase\GetAllEntities;

use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Exception;
use PDOException;
use Symfony\Component\HttpFoundation\Response;

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
            return $this->createUnsuccessfullyResponse(ResultCodes::CODE_PDO_EXCEPTION, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::CODE_UNKNOWN_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new GetAllEntitiesResponse(ResultCodes::CODE_SUCCESS, $list);
    }
}
