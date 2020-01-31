<?php

namespace App\Usecase\DeleteEntity;

use App\Entity\Day;
use App\Repository\Exception\EntityNotFoundException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseRequest;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Exception;
use PDOException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class DeleteEntityInteractor extends BaseInteractor
{
    /**
     * @param BaseRequest $request
     * @return BaseResponse
     */
    public function execute(BaseRequest $request): BaseResponse
    {
        try {
            $entity = $this->createEntityFromRequest($request);
            $list = $this->repository->delete($entity);
        } catch (PDOException $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::PDO_EXCEPTION, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (EntityNotFoundException $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::ENTITY_NOT_FOUND_EXCEPTION, Response::HTTP_NOT_FOUND);
        } catch (Throwable $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new DeleteEntityResponse(ResultCodes::SUCCESS, $list);
    }

    /**
     * @param BaseRequest $request
     * @return Day
     * @throws Exception
     */
    private function createEntityFromRequest(BaseRequest $request): Day
    {
        $day = new Day();
        $day->date = $request->date;

        return $day;
    }
}
