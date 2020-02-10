<?php

namespace App\Usecase\AddMultiEntities;

use App\Entity\Day;
use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use DateTime;
use PDOException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
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

//            var_dump($this->createRangeOfDays($request));
//            exit;


//            foreach ($this->createRangeOfDays($request->fromDate, $request->toDate) as $entity) {
//                $this->repository->save();
//            }
        } catch (DatabaseException $exception) {
            return $this->createUnsuccessfullyResponse($exception->getCode());
        } catch (PDOException $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::PDO_EXCEPTION);
        } catch (Throwable $throwable) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR);
        }

        $response = new AddMultiEntitiesResponse(ResultCodes::SUCCESS);
        $response->setHttpStatus(Response::HTTP_CREATED);;

        return $response;
    }

    /**
     * @param AddMultiEntitiesRequest $request
     * @return array
     * @throws \Exception
     */
    private function createRangeOfDays(AddMultiEntitiesRequest $request): array
    {
        $toDate = new DateTime($request->toDate);
        $toDate = $toDate->modify('+1 day');

        $range = new \DatePeriod(new DateTime($request->date), new \DateInterval('P1D'), $toDate);
        $days = [];

        /** @var $date DateTime */
        foreach ($range as $date) {
            $day = new Day();
            $day->date = $date->format(self::DEFAULT_DATE_FORMAT);
            $day->mode = $request->mode;
            $day->begin = '';

            $days[] = $day;
        }

        return $days;
    }
}
