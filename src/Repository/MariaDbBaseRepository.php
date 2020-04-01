<?php

namespace App\Repository;

use App\Repository\Exception\DatabaseException;
use App\Repository\Mapper\MariaDbMapper as Mapper;
use App\Service\CacheService;
use App\Usecase\ResultCodes;
use PDO;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class MariaDbBaseRepository
{
    private const DATABASE_CONNECTION_TIMEOUT = 30;

    private ?PDO $pdo = null;
    private Mapper $mapper;
    private CacheService $cache;

    /**
     * @param Mapper $mapper
     * @param CacheService $cache
     */
    public function __construct(Mapper $mapper, CacheService $cache)
    {
        $this->mapper = $mapper;
        $this->cache = $cache;
    }

    /**
     * @info for unittests only
     * @param PDO $pdo
     */
    public function setPdoDriver(PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param bool $overwrite
     * @return bool
     */
    protected function storeInCache(string $key, $value, bool $overwrite = true): bool
    {
        return $this->cache->set($key, $value, $overwrite);
    }

    /**
     * @param string $key
     * @return mixed
     */
    protected function getFromCache(string $key)
    {
        return $this->cache->get($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function clearCacheByKey(string $key): bool
    {
        return $this->cache->delete($key);
    }

    /**
     * @return Mapper
     */
    protected function getMapper(): Mapper
    {
        return $this->mapper;
    }

    /**
     * @return PDO
     * @throws DatabaseException
     */
    protected function getPdoDriver(): PDO
    {
        if (null === $this->pdo) {
            $host = getenv('MARIADB_HOST');
            $user = getenv('MARIADB_USER');
            $password = getenv('MARIADB_PASSWORD');
            $name = getenv('MARIADB_NAME');
            $port = getenv('MARIADB_PORT');

            if (empty($host) || empty($user) || empty($password) || empty($name) || empty($port)) {
                throw new DatabaseException(ResultCodes::PDO_EXCEPTION_NO_LOGIN_DATA);
            }

            $this->pdo = new PDO("mysql:dbname=$name;host=$host;port=$port;charset=utf8mb4", $user, $password, [
                PDO::ATTR_TIMEOUT => self::DATABASE_CONNECTION_TIMEOUT
            ]);
        }

        return $this->pdo;
    }
}
