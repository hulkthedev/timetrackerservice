<?php

namespace App\Usecase\AddMultiEntities;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use DateInterval;
use DatePeriod;
use DateTime;
use Exception;
use PDOException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @author ~albei <fatal.error.27@gmail.com>
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
            foreach ($this->createRangeOfDays($request) as $entity) {
                $this->repository->save(
                    $entity['date'],
                    $entity['employerId'],
                    $entity['employerWorkingTimeId'],
                    $entity['mode'],
                    $entity['begin']
                );
            }
        } catch (DatabaseException $exception) {
            return $this->createUnsuccessfullyResponse($exception->getCode());
        } catch (Throwable $throwable) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR);
        }

        $response = new AddMultiEntitiesResponse(ResultCodes::SUCCESS);
        $response->setHttpStatus(Response::HTTP_CREATED);

        return $response;
    }

    /**
     * @param AddMultiEntitiesRequest $request
     * @return array
     * @throws Exception
     */
    private function createRangeOfDays(AddMultiEntitiesRequest $request): array
    {
        $toDate = new DateTime($request->toDate);
        $toDate = $toDate->modify('+1 day');

        $range = new DatePeriod(new DateTime($request->date), new DateInterval('P1D'), $toDate);
        $days = [];

        /** @var $date DateTime */
        foreach ($range as $date) {
            $day = [
                'date' => $date->format(self::DEFAULT_DATE_FORMAT),
                'employerId' => $request->employerId,
                'employerWorkingTimeId' => $request->employerWorkingTimeId,
                'mode' => $request->mode,
                'begin' => 0
            ];

            $days[] = $day;
        }

        return $days;
    }
}
