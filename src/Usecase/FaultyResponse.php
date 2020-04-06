<?php

namespace App\Usecase;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class FaultyResponse
{
    private int $code;
    private string $message;

    /**
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message, int $code = ResultCodes::INVALID_SYNTAX)
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
