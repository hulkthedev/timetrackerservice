<?php

namespace App\Usecase\AddEntity;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use PDOException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
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
            $this->repository->save(
                $request->date,
                $request->employerId,
                $request->employerWorkingTimeId,
                $request->mode,
                $request->begin
            );
        } catch (DatabaseException $exception) {
            return $this->createUnsuccessfullyResponse($exception->getCode());
        } catch (PDOException $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::PDO_EXCEPTION);
        } catch (Throwable $throwable) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR);
        }

        $response = new AddEntityResponse(ResultCodes::SUCCESS);
        $response->setHttpStatus(Response::HTTP_CREATED);;

        return $response;
    }
}
