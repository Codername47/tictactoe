<?php

namespace TestWork\Model\Data;

use PDO;

class DatabaseCreate
{
    private $sqlDBCreateQuery;
    private $sqlUserTableCreateQuery;
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->sqlDBCreateQuery = "CREATE DATABASE tictactoe";
    }

    public function create()
    {
        $this->createDatabase();
        $this->createTables();
    }

    public function createOnlyTables()
    {
        $this->createTables();
    }

    private function createDatabase()
    {
        $this->connection->exec($this->sqlDBCreateQuery);
    }
    private function createTables()
    {
        echo '1';

        $queries = DBInfo::getInfo()['queries'];
        $tables = DBInfo::getInfo()['tables'];
        foreach ($queries as $query)
        {
            $this->connection->exec($query);
        }
    }

}