<?php
include_once "config.php";
class Db
{
    private $dbHost = DBHOST;
    private $dbUser = DBUSER;
    private $dbPassword = DBPASS;
    private $dbName = DBNAME;
    protected $conn;
    public function connect()
    {
        //PDO($dsn,$user,$password)
        $dsn = "mysql:host=$this->dbHost;dbname=$this->dbName";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try {
            $this->conn = new PDO($dsn, $this->dbUser, $this->dbPassword, $options);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $this->conn;
    }
}