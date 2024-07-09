<?php

namespace Classes;

use PDO;
use PDOException;

class Db
{

    public function connect($obj)
    {

        try {
            $pdo = new PDO("mysql:host=$obj->servername;dbname=$obj->dbname", $obj->username, $obj->password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw $e;
        }
        return $pdo;
    }
}
