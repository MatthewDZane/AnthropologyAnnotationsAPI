<?php
require_once "Annotation.php";
require_once "Group.php";
class Database
{
    protected mysqli $connection;

    protected string $lastError = "";

    public function getLastError() { return $this->lastError; }

    public function __construct()
    {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
    	
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");   
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }			
    }
}

?>