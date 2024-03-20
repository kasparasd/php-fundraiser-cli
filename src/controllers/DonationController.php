<?php

namespace App\controllers;

use App\CliPrinter;
use App\models\Donation;

class DonationController
{

    private Donation $donation;
    public function __construct(private array $argv)
    {
        $this->donation = new Donation();
    }

    public function add()
    {
        $id = $this->argv[2];
        $amount = $this->argv[3];
        $donator = $this->argv[4];

        if ($amount <= 0) {
            return CliPrinter::error("Amount should be positive");
        }
        if (strlen($donator) < 8) {
            return CliPrinter::error("Donator name should be at least 8 characters long");
        }
        if (strlen($donator) > 50) {
            return CliPrinter::error("Donator name should be no longer than 50 characters");
        }

        $state = $this->donation->add($id, $amount, str_replace('_', ' ', $donator));

        if ($state) {
            CliPrinter::message('Donation successfully added');
        }
    }
}