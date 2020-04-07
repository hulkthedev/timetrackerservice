<?php

namespace App\Tests\Cache;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class ApcuCacheItemPoolTest extends TestCase
{
    /**
     * @return array
     */
    public function keyDataProvider(): array
    {
        return [
            ['ABCDEF', true],
            ['123456', true],
            [123456, true],
            ['ABC_DEF', true],
            ['ABC_123', true],
            ['123_ABC', true],

            ['.ABC', false],
            ['ABC.', false],
            ['.ABC.', false],
            ['-ABC', false],
            ['ABC-', false],
            ['-ABC-', false],
            ['_ABC_123', false],
            ['ABC_123_', false],
            ['_ABC_123_', false],
            [false, false],
            [true, false]
        ];
    }

    /**
     * @dataProvider keyDataProvider
     * @param string $key
     * @param bool $isValid
     * @throws Exception
     */
    public function test_cacheKeyValidation($key, bool $isValid): void
    {
        $pool = new ApcuCacheItemPoolStub();
        TestCase::assertEquals($isValid, $pool->isKeyValid($key));
    }
}
