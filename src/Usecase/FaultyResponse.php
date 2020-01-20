<?php

namespace App\Usecase;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class FaultyResponse
{
    /** @var int */
    private $code = ResultCodes::CODE_SYNTAX_ERROR;

    /** @var string */
    private $message = 'Syntax error on attribute {{attribute}}';

    /** @var int */
    private $httpStatus = Response::HTTP_BAD_REQUEST;

    /** @var string */
    private $prop;

    /**
     * @param ConstraintViolationListInterface $violations
     */
    public function __construct(ConstraintViolationListInterface $violations)
    {
        $this->prop = $violations->get(0)->getPropertyPath();
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

       /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param int $httpStatus
     */
    public function setHttpStatus(int $httpStatus): void
    {
        $this->httpStatus = $httpStatus;
    }

    /**
     * @return int
     */
    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    /**
     * @return array
     */
    public function presentResponse(): array
    {
        $message = str_replace('{{attribute}}', $this->prop, $this->message);
        return [
            'code' => $this->code,
            'message' => $message
        ];
    }
}
