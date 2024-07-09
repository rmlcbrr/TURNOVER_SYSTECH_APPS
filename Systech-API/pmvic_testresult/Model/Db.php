<?php
class Db
{
    private $servername = "127.0.0.1";
    private $port = "3306";
    private $username = "v1-testing";
    private $password = "0VbUN6TTDp8rjNyzv9G6";
    private $dbname  = "v1-testing";
  
    public function connect()
    {
        try {
            $pdo = new PDO("mysql:host=$this->servername;port=$this->port;dbname=$this->dbname", $this->username, $this->password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw $e;
        }
        return $pdo;
    }
}
