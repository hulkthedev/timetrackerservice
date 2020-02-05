<?php

namespace App\Usecase\AddMultiEntities;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class AddMultiEntitiesInteractor extends BaseInteractor
{
    /**
     * @param AddMultiEntitiesRequest $request
     * @return BaseResponse
     */
    public function execute(AddMultiEntitiesRequest $request): BaseResponse
    {
        try {
//            foreach ($this->createRangeOfDays($request->fromDate, $request->toDate) as $entity) {
//                $this->repository->save();
//            }
        } catch (DatabaseException $exception) {
            return $this->createUnsuccessfullyResponse($exception->getCode());
        } catch (\PDOException $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::PDO_EXCEPTION);
        } catch (\Throwable $throwable) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR);
        }

        $response = new AddMultiEntitiesResponse(ResultCodes::SUCCESS);
        $response->setHttpStatus(Response::HTTP_CREATED);;

        return $response;
    }

    /**
     * @param string $from
     * @param string $to
     * @return array
     */
    private function createRangeOfDays(string $from, string $to): array
    {

    }
}
