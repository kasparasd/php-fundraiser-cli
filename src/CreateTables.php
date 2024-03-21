<?php

namespace App;

use PDO;
use PDOException;

class CreateTables
{
    public static function create()
    {
        $config = (new MariaDbConfig(ENV))->mariaDbConfig();
        $dbName = $config['database'];
        $host = $config['host'];
        $user = $config['user'];
        $pass = $config['password'];

        try {
            $conn = new PDO("mysql:host=$host", $user, $pass);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "CREATE DATABASE IF NOT EXISTS $dbName";

            $conn->exec($sql);
            CliPrinter::message("Database: $dbName created");
            
        } catch (PDOException $e) {
            CliPrinter::error($e->getMessage());
        }
        $conn = null;
        
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
            $charityColumns = "id INT( 11 ) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR( 128 ) NOT NULL, email VARCHAR( 128 ) NOT NULL";
            $donationColumns = "id INT( 11 ) AUTO_INCREMENT PRIMARY KEY, donor_name VARCHAR( 128 ) NOT NULL, amount decimal( 10,0 ) NOT NULL, charity_id INT( 11 ) UNSIGNED, FOREIGN KEY (charity_id) REFERENCES charities(id) ON DELETE cascade, date_time datetime DEFAULT current_timestamp()";
            $conn->exec("CREATE TABLE IF NOT EXISTS `charities` ($charityColumns)");
            $conn->exec("CREATE TABLE IF NOT EXISTS `donations` ($donationColumns)");

            CliPrinter::message("Tables: charities and donations created in database: $dbName");
        } catch (PDOException $e) {
            CliPrinter::error($e->getMessage());
        }
        $conn = null;
    }
}
