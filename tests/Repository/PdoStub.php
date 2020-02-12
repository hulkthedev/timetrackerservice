<?php

namespace App\Tests\Repository;

use PDO;
use PDOStatement;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class PdoStub extends PDO
{
    private array $fetchAllReturnValue = [];
    private bool $executeReturnValue = true;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
    }

    /**
     * @param array $fetchAllReturnValue
     * @return PDO
     */
    public function setFetchAllReturnValue(array $fetchAllReturnValue): PDO
    {
        $this->fetchAllReturnValue = $fetchAllReturnValue;
        return $this;
    }

    /**
     * @param bool $executeReturnValue
     * @return PDO
     */
    public function setExecuteReturnValue(bool $executeReturnValue): PDO
    {
        $this->executeReturnValue = $executeReturnValue;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function prepare($statement, $options = null)
    {
        return new PDOStatementStub(
            $this->fetchAllReturnValue,
            $this->executeReturnValue
        );
    }
}

class PDOStatementStub extends PDOStatement
{
    private array $fetchAllReturnValue;
    private bool $executeReturnValue;

    /**
     * @param array $fetchAllReturnValue
     * @param bool $executeReturnValue
     */
    public function __construct(array $fetchAllReturnValue, bool $executeReturnValue)
    {
        $this->fetchAllReturnValue = $fetchAllReturnValue;
        $this->executeReturnValue = $executeReturnValue;
    }

    /**
     * @inheritdoc
     */
    public function execute($input_parameters = null)
    {
        return $this->executeReturnValue;
    }

    /**
     * @inheritdoc
     */
    public function fetchAll($fetchMode = null, $fetchArgument = null, $ctorArgs = null)
    {
        return $this->fetchAllReturnValue;
    }
}
