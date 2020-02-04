<?php

namespace App\Repository;

use App\Repository\Exception\DatabaseException;
use App\Repository\Mapper\MariaDbToJsonMapper as Mapper;
use App\Usecase\AddEntity\AddEntityRequest;
use App\Usecase\DeleteEntity\DeleteEntityRequest;
use App\Usecase\GetEntity\GetEntityRequest;
use App\Usecase\ResultCodes;
use App\Usecase\UpdateEntity\UpdateEntityRequest;
use PDO;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class MariaDbTrackingRepository implements RepositoryInterface
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
     * @inheritDoc
     */
    public function getAll(): array
    {
        $statement = $this->getPdoDriver()->query('SELECT * FROM timetracking');
        $list = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (empty($list)) {
            throw new DatabaseException(ResultCodes::DATABASE_IS_EMPTY);
        }

        return $this->mapper->map($list);
    }

    /**
     * @inheritDoc
     */
    public function get(GetEntityRequest $request): array
    {
        $statement = $this->getPdoDriver()->prepare('SELECT * FROM timetracking WHERE date = :date');
        $statement->execute(['date' => $request->date]);

        $entity = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($entity)) {
            throw new DatabaseException(ResultCodes::ENTITY_NOT_FOUND);
        }

        return $this->mapper->map($entity);
    }

    /**
     * @inheritDoc
     */
    public function save(AddEntityRequest $request): bool
    {
        $query = 'INSERT INTO timetracking (date, mode, begin_timestamp, end_timestamp, delta) VALUES (:date, :mode, :begin_timestamp, :end_timestamp, :delta)';
        $statement = $this->getPdoDriver()->prepare($query);

        $result = $statement->execute([
            'date' => $request->date,
            'mode' => $request->mode,
            'begin_timestamp' => $request->begin,
            'end_timestamp' => 0,
            'delta' => 0
        ]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_SAVED);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function update(UpdateEntityRequest $request): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function delete(DeleteEntityRequest $request): bool
    {
        $statement = $this->getPdoDriver()->prepare('DELETE FROM timetracking WHERE date = :date');
        $result = $statement->execute(['date' => $request->date]);

        if (true !== $result) {
            throw new DatabaseException(ResultCodes::ENTITY_CAN_NOT_BE_DELETED);
        }

        return true;
    }

    /**
     * @return PDO
     * @throws DatabaseException
     */
    private function getPdoDriver(): PDO
    {
        if (null === $this->pdo) {
            $host = getenv('MARIADB_HOST');
            $user = getenv('MARIADB_USER');
            $password = getenv('MARIADB_PASSWORD');
            $name = getenv('MARIADB_NAME');
            $port = getenv('MARIADB_PORT');

            if (empty($host) || empty($user) || empty($password) || empty($name) || empty($port)) {
                throw new DatabaseException(ResultCodes::PDO_EXCEPTION);
            }

            $this->pdo = new PDO("mysql:dbname=$name;host=$host;port=$port;charset=utf8mb4", $user, $password, [
                PDO::ATTR_TIMEOUT => self::DATABASE_CONNECTION_TIMEOUT
            ]);
        }

        return $this->pdo;
    }
}
