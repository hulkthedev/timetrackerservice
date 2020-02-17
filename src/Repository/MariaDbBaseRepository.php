<?php

namespace App\Repository;

use App\Repository\Exception\DatabaseException;
use App\Repository\Mapper\MariaDbMapper as Mapper;
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

    /**
     * @param Mapper $mapper
     */
    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param PDO $pdo
     */
    public function setPdoDriver(PDO $pdo): void
    {
        $this->pdo = $pdo;
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
