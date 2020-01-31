<?php

namespace App\Usecase;

use App\Repository\MariaDbTrackingRepository;
use App\Repository\RepositoryInterface;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class BaseInteractor
{
    protected const DEFAULT_DATE_FORMAT = 'Y-m-d';
    protected const DEFAULT_TIME_FORMAT = 'H:i:s';
    protected const DEFAULT_DATE_TIME_FORMAT = self::DEFAULT_DATE_FORMAT . ' ' . self::DEFAULT_TIME_FORMAT;

    protected RepositoryInterface $repository;

    /**
     * @param MariaDbTrackingRepository $repository
     */
    public function __construct(MariaDbTrackingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $code
     * @param int $httpStatus
     * @return BaseResponse
     */
    protected function createUnsuccessfullyResponse(int $code, int $httpStatus): BaseResponse
    {
        $response = new BaseResponse($code);
        $response->setHttpStatus($httpStatus);

        return $response;
    }
}
