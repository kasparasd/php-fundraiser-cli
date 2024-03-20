<?php

namespace App;

use PDO;

class Db
{

    private PDO $pdo;

    public function __construct($dbConfig)
    {
        $dsn = "mysql:host=$dbConfig[host];dbname=$dbConfig[database];charset=UTF8";
        try {
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ];
            $this->pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], $options);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function __call($method, $args)
    {
       return call_user_func_array([$this->pdo, $method], $args);
    }
}
