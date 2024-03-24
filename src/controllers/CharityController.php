<?php

namespace src\controllers;

use src\CliPrinter;
use src\models\Charity;
use src\validations\CharityValidation;

class CharityController
{
    private Charity $charity;
    public function __construct(private array $argv)
    {
        $this->charity = new Charity();
    }

    public function findAll()
    {
        $charities = $this->charity->findAll();
        if (count($charities) === 0) {
            return CliPrinter::message("There are no active charities.");
        }
        foreach ($charities as $value) {
            CliPrinter::message("Charity: #id: $value->id, name: $value->name, Email: $value->email");
        }
    }
    public function store()
    {
        if (!CharityValidation::hasValidInputCount($this->argv, 4)) {
            return CliPrinter::error('Too few/many arguments inserted, please run: php index.php create ["Charity name"] [Email address]');
        }

        $name = trim($this->argv[2], "'\"");
        $email = $this->argv[3];

        if (!CharityValidation::hasValidNameLength($name, 8, 50)) {
            return CliPrinter::error("Charity name should be 8-50 characters long");
        }

        if (!CharityValidation::email($email)) {
            return CliPrinter::error("Email is not valid");
        }

        $this->charity->store($name, $email);
        CliPrinter::message("New charity successfully added");
    }
    public function update()
    {
        if (!CharityValidation::hasValidInputCount($this->argv, 5)) {
            return CliPrinter::error('Too few/many arguments inserted, please run: php index.php edit [Charity id] ["New charity name"] [New email address]');
        }

        $id = $this->argv[2];
        $name = trim($this->argv[3], "'\"");
        $email = $this->argv[4];

        if (!CharityValidation::hasValidNameLength($name, 8, 50)) {
            return CliPrinter::error("Charity name should be 8-50 characters long");
        }
        if (!CharityValidation::email($email)) {
            return CliPrinter::error("Email is not valid");
        }
        if (!$this->find($id)) {
            return CliPrinter::error("Charity with this id: $id does not exist");
        }
        $this->charity->update($id, $name, $email);
        CliPrinter::message("Charity successfully updated");
    }
    public function destroy()
    {
        $id = $this->argv[2];
        if (!$this->find($id)) {
            return CliPrinter::error("Charity with this id: $id does not exist");
        }

        $this->charity->destroy($id);
        CliPrinter::message("Charity successfully deleted");
    }

    private function find($id)
    {
        return $this->charity->find($id);
    }

    public function csv()
    {
        $fileName = $this->argv[2];
        $csvFileLocation = CSVLOCATION . $fileName;

        $file = fopen($csvFileLocation, 'r');

        $id = 0;
        $charitiesAdded = 0;

        while (($data = fgetcsv($file, 1000, ',')) !== false) {
            $id++;
            if (count($data) < 2) {
                CliPrinter::error("To few arguments passed in row $id");
                continue;
            }
            if (count($data) > 2) {
                CliPrinter::error("To many arguments passed in row $id");
                continue;
            }
            $name = $data[0];
            $email = $data[1];
            if (!CharityValidation::email($email)) {
                CliPrinter::error("Email is not valid in row $id");
                continue;
            }
            if (!CharityValidation::hasValidNameLength($name, 8, 50)) {
                CliPrinter::error("Charity name should be 8-50 characters long in row $id");
                continue;
            }
            $this->charity->store($name, $email);
            $charitiesAdded++;
        }
        CliPrinter::message("$charitiesAdded charities were added");
    }
}
