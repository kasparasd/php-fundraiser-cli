<?php

namespace App\validations;
use App\CliPrinter;

class DonationValidation {
    public function amount($amount){
        if($amount<=0){
            CliPrinter::error("Amount should be positive");
            return false;
        }
    }
}