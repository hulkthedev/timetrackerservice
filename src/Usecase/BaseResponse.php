<?php

namespace App\Usecase;

use App\Entity\Day;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class BaseResponse
{
    private int $code;

    /** @var Day[] */
    private array $entities;
    private int $httpStatus = Response::HTTP_OK;

    /**
     * @param int $code
     * @param Day[] $entities
     */
    public function __construct(int $code, array $entities = [])
    {
        $this->code = $code;
        $this->entities = $entities;
    }

    /**
     * @return int
     */
    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    /**
     * @param int $httpStatus
     */
    public function setHttpStatus(int $httpStatus): void
    {
        $this->httpStatus = $httpStatus;
    }

    /**
     * @return array
     */
    public function presentResponse(): array
    {
        return [
            'code' => $this->code,
            'entities' => $this->entities
        ];
    }
}
