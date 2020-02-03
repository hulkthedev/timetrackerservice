<?php

namespace App\Usecase;

use App\Repository\MariaDbTrackingRepository;
use App\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class BaseInteractor
{
    public const DEFAULT_DATE_FORMAT = 'Y-m-d';
    public const DEFAULT_TIME_FORMAT = 'H:i:s';
    public const DEFAULT_DATE_TIME_FORMAT = self::DEFAULT_DATE_FORMAT . ' ' . self::DEFAULT_TIME_FORMAT;

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
    protected function createUnsuccessfullyResponse(int $code, int $httpStatus = Response::HTTP_INTERNAL_SERVER_ERROR): BaseResponse
    {
        $response = new BaseResponse($code);
        $response->setHttpStatus($httpStatus);

        return $response;
    }
}
