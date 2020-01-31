<?php

namespace App\Usecase\AddEntity;

use App\Entity\Day;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use DateTime;
use Exception;
use PDOException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
            $entity = $this->createEntityFromRequest($request);
            $list = $this->repository->save($entity);
        } catch (PDOException $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::PDO_EXCEPTION, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new AddEntityResponse(ResultCodes::SUCCESS, $list);
    }

    /**
     * @param AddEntityRequest $request
     * @return Day
     * @throws Exception
     */
    private function createEntityFromRequest(AddEntityRequest $request): Day
    {
        $dateTime = new DateTime();
        $dateTime->setTimestamp($request->begin);

        $day = new Day();
        $day->mode = $request->mode;
        $day->date = $request->date;
        $day->begin = $dateTime->format(self::DEFAULT_TIME_FORMAT);

        return $day;
    }
}
