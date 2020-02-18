<?php

namespace App\Usecase;

use App\Repository\MariaDbConfigRepository;
use App\Repository\RepositoryInterface;
use App\Service\CalculationService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class BaseInteractor
{
    public const DEFAULT_DATE_FORMAT = 'Y-m-d';
    public const DEFAULT_TIME_FORMAT = 'H:i';
    public const DEFAULT_DATE_TIME_FORMAT = self::DEFAULT_DATE_FORMAT . ' ' . self::DEFAULT_TIME_FORMAT;

    protected RepositoryInterface $repository;
    protected MariaDbConfigRepository $configRepository;
    protected CalculationService $calculationService;

    /**
     * @param RepositoryInterface $repository
     * @param MariaDbConfigRepository $configRepository
     * @param CalculationService $calculationService
     */
    public function __construct(
        RepositoryInterface $repository,
        MariaDbConfigRepository $configRepository,
        CalculationService $calculationService
    ) {
        $this->repository = $repository;
        $this->configRepository = $configRepository;
        $this->calculationService = $calculationService;
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
