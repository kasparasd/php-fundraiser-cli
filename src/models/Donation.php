<?php

namespace src\models;

use src\CliPrinter;
use src\Model;

class Donation extends Model
{
    public function add($charity_id, $amount, $donor_name)
    {
        $date_time = date("Y-m-d H:i:s");

        try {
            $sql = "INSERT INTO donations (donor_name, amount, charity_id, date_time)
             VALUES (:donor_name, :amount, :charity_id, :date_time)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':donor_name', $donor_name);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':charity_id', $charity_id);
            $stmt->bindParam(':date_time', $date_time);
            $stmt->execute();
            return true;
        } catch (\PDOException) {
            return $stmt->errorInfo();
        }
    }
}
