<?php

namespace App\Usecase;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class FaultyResponse
{
    /** @var int */
    private $code;

    /** @var string */
    private $message;

    /**
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message, int $code = ResultCodes::CODE_INVALID_SYNTAX)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function presentResponse(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}
