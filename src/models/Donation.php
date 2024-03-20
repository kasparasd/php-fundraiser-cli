<?php

namespace App\models;

use App\CliPrinter;
use App\Model;

class Donation extends Model
{
    public function add($charity_id, $amount, $donor_name)
    {
        $date_time = date("Y-m-d H:i:s");

        try {
            $sql = "INSERT INTO donations (donor_name, amount, charity_id, date_time) VALUES (:donor_name, :amount, :charity_id, :date_time)";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':donor_name', $donor_name);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':charity_id', $charity_id);
            $stmt->bindParam(':date_time', $date_time);

            $stmt->execute();
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                CliPrinter::error("Charity id: $charity_id does not exist. To see charities run: php index.php charities");
            } else {
                CliPrinter::error($e->getMessage());
            }
            return false;
        }

        return true;
    }
}
