<?php

namespace TestWork\Model\Data;

use PDO;
use PDOException;

class DatabaseConnect
{
    private static ?DatabaseConnect $instance = null;
    private $conf;
    private PDO $conn;
    private ?DatabaseCreate $DBCreator = null;
    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (self::$instance === null){
            self::$instance = new self();
        }

        return self::$instance;
    }
    public function connect()
    {

        $this->checkConnectionWithDB();
        $this->checkDatabaseExistance();
        $this->checkTablesExistance();
    }
    private function checkConnectionWithDB()
    {
        try{
            $this->conf = DBConfig::getConfig();
            $this->conn = new PDO("mysql:host=".$this->conf['host'], $this->conf['username'], $this->conf['password']);
            echo "Database is available\n";
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            die();
        }
    }

    private function checkDatabaseExistance()
    {
        try{
            $this->conn = new PDO(
                "mysql:host=".$this->conf['host'].";dbname=".$this->conf['database'],
                $this->conf['username'],
                $this->conf['password']
            );
        } catch (PDOException $e) {
            $this->DBCreator = new DatabaseCreate($this->conn);
            $this->DBCreator->create();
            echo "Database is created\n";
        }

    }
    private function checkTablesExistance()
    {
        try{
            if (!$this->DBCreator)
                $this->DBCreator = new DatabaseCreate($this->conn);
            $this->DBCreator->createOnlyTables();
        } catch (PDOException $e) {
            echo "tables are Already created";
        }
    }
}