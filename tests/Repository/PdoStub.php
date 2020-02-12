<?php

namespace App\Tests\Repository;

use PDO;
use PDOStatement;

/**
 * @author Alexej Beirith <fatal.error.27@gmail.com>
 */
class PdoStub extends PDO
{
    /** @var array|bool  */
    private $returnValue;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
    }

    /**
     * @param array|bool $returnValue
     * @return PDO
     */
    public function setReturnValue($returnValue): PDO
    {
        $this->returnValue = $returnValue;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function prepare($statement, $options = null)
    {
        return new PDOStatementStub($this->returnValue);
    }
}

class PDOStatementStub extends PDOStatement
{
    /** @var array|bool */
    private $returnValue;

    /**
     * @param array|bool $returnValue
     */
    public function __construct($returnValue)
    {
        $this->returnValue = $returnValue;
    }

    /**
     * @inheritdoc
     */
    public function fetchAll($fetchMode = null, $fetchArgument = null, $ctorArgs = null)
    {
        return $this->returnValue;
    }
}
