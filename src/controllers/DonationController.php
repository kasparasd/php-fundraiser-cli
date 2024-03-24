<?php

namespace src\controllers;

use src\CliPrinter;
use src\models\Donation;

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
        $donator = trim($this->argv[4], "'\"");

        if ($amount <= 0) {
            return CliPrinter::error("Amount should be positive");
        }
        if (strlen($donator) < 8) {
            return CliPrinter::error("Donator name should be at least 8 characters long");
        }
        if (strlen($donator) > 50) {
            return CliPrinter::error("Donator name should be no longer than 50 characters");
        }

        $status = $this->donation->add($id, $amount, $donator);

        if ($status === true) {
            return CliPrinter::message('Donation successfully added');
        } elseif ($status[1] === 1452) {
            return CliPrinter::error("Charity with this id: $id does not exist");
        };
    }
}
