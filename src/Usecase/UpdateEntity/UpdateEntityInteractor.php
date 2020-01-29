<?php

namespace App\Usecase\UpdateEntity;

use App\Entity\Day;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use DateTime;
use Exception;
use PDOException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class UpdateEntityInteractor extends BaseInteractor
{
    /**
     * @param UpdateEntityRequest $request
     * @return BaseResponse
     */
    public function execute(UpdateEntityRequest $request): BaseResponse
    {
        try {
            $entity = $this->createEntityFromRequest($request);
            $list = $this->repository->update($entity);
        } catch (PDOException $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::CODE_PDO_EXCEPTION, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::CODE_UNKNOWN_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new UpdateEntityResponse(ResultCodes::CODE_SUCCESS, $list);
    }

    /**
     * @param UpdateEntityRequest $request
     * @return Day
     * @throws Exception
     */
    private function createEntityFromRequest(UpdateEntityRequest $request): Day
    {
        $beginDateTime = new DateTime();
        $beginDateTime->setTimestamp($request->begin);

        $endDateTime = new DateTime();
        $endDateTime->setTimestamp($request->end);

        $day = new Day();
        $day->mode = $request->mode;
        $day->date = $request->date;
        $day->begin = $beginDateTime->format(self::DEFAULT_TIME_FORMAT);
        $day->end = $endDateTime->format(self::DEFAULT_TIME_FORMAT);

        return $day;
    }
}
