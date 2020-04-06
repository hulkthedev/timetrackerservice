<?php

namespace App\Cache;

use Psr\Cache\CacheItemInterface;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class CacheItem implements CacheItemInterface
{
    public const PREFIX_CONFIG = 'config_';
    public const PREFIX_WORKING_TIME = 'working_time_';

    /** @var mixed */
    private $value;

    private string $key;
    private bool $isHit = false;
    private int $expiry = 0;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return int
     */
    public function getExpiry(): int
    {
        return $this->expiry;
    }

    /**
     * @inheritDoc
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function isHit(): bool
    {
        return $this->isHit;
    }

    /**
     * @inheritDoc
     */
    public function set($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function expiresAt($expiration): self
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function expiresAfter($time): self
    {
        $this->expiry = $time;
        return $this;
    }
}
