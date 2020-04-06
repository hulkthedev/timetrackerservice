<?php

namespace App\Tests\Usecase;

use App\Usecase\FaultyResponse;
use PHPUnit\Framework\TestCase;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class FaultyResponseTest extends TestCase
{
    public function testSetAndGet(): void
    {
        $response = new FaultyResponse('UnitTest', 99);
        $result = $response->presentResponse();

        TestCase::assertEquals('UnitTest', $result['message']);
        TestCase::assertEquals(99, $result['code']);
    }
}
