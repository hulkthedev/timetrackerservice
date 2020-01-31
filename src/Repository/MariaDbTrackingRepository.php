<?php

namespace App\Repository;

use App\Entity\Day;
use App\Repository\Exception\DatabaseGoneException;
use App\Usecase\ResultCodes;
use PDO;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class MariaDbTrackingRepository implements RepositoryInterface
{
    private const DATABASE_CONNECTION_TIMEOUT = 30;

    private PDO $pdo;

    /**
     * @throws DatabaseGoneException
     */
    public function __construct()
    {
        $host = getenv('MARIADB_HOST');
        $user = getenv('MARIADB_USER');
        $password = getenv('MARIADB_PASSWORD');
        $name = getenv('MARIADB_NAME');
        $port = getenv('MARIADB_PORT');

        if (empty($host) || empty($user) || empty($password) || empty($name) || empty($port)) {
            throw new DatabaseGoneException();
        }

        $dsn = "mysql:dbname=$name;host=$host;port=$port;charset=utf8mb4";
        $this->pdo = new PDO($dsn, $user, $password, [PDO::ATTR_TIMEOUT => self::DATABASE_CONNECTION_TIMEOUT]);
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        die('getAll');
    }

    /**
     * @inheritDoc
     */
    public function get(Day $entity)
    {
        die('get');
    }

    /**
     * @inheritDoc
     */
    public function save(Day $entity)
    {
        die('save');
    }

    /**
     * @inheritDoc
     */
    public function update(Day $entity)
    {
        die('update');
    }

    /**
     * @inheritDoc
     */
    public function delete(Day $entity)
    {
        die('delete');
    }
}
