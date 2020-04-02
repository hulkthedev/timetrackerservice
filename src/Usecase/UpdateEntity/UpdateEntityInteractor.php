<?php

namespace App\Usecase\UpdateEntity;

use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use DateTime;
use PDOException;
use Psr\Cache\InvalidArgumentException;
use Throwable;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
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
            $config = $this->configRepository->getConfig($request->employerId, $request->employerWorkingTimeId);
            $delta = $this->calculationService->setConfig($config)
                ->calculateDelta($request->begin, $request->end, $request->break);

            $this->repository->update(
                $request->date,
                $request->employerId,
                $request->employerWorkingTimeId,
                $request->mode,
                $request->begin,
                $request->end,
                $request->break,
                $delta
            );
        } catch (DatabaseException $exception) {
            return $this->createUnsuccessfullyResponse($exception->getCode());
        } catch (PDOException $exception) {
            return $this->createUnsuccessfullyResponse(ResultCodes::PDO_EXCEPTION);
        } catch (Throwable $throwable) {
            return $this->createUnsuccessfullyResponse(ResultCodes::UNKNOWN_ERROR);
        }

        return new UpdateEntityResponse(ResultCodes::SUCCESS);
    }
}
