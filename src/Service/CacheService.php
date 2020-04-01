<?php

namespace App\Service;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
interface CacheService
{
    /**
     * @param string $key
     * @param mixed $value
     * @param bool $overwrite
     * @return bool
     */
    public function set(string $key, $value, bool $overwrite = true): bool;

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool;

    /**
     * @param string $key
     * @return bool
     */
    public function isset(string $key): bool;

    public function clear(): void;
}
