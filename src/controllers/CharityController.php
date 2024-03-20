<?php

namespace App\controllers;

use App\CliPrinter;
use App\models\Charity;
use App\validations\CharityValidation;

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
        if (!CharityValidation::inputs($this->argv)) {
            return;
        }

        $name = $this->argv[2];
        $email = $this->argv[3];

        if (!CharityValidation::name($name) || !CharityValidation::email($email)) {
            return;
        }

        $this->charity->store(str_replace('_', ' ', $name), $email);
        CliPrinter::message("New charity successfully added");
    }
    public function update()
    {
        if (!CharityValidation::inputs($this->argv)) {
            return;
        }

        $id = $this->argv[2];
        $name = $this->argv[3];
        $email = $this->argv[4];

        if (!CharityValidation::name($name) || !CharityValidation::email($email)) {
            return;
        }
        if (!$this->find($id)) {
            return CliPrinter::error("Charity with this id: $id does not exist");
        };
        $this->charity->update($id, str_replace('_', ' ', $name), $email);
        CliPrinter::message("Charity successfully updated");
    }
    public function destroy()
    {
        $id = $this->argv[2];
        if (!$this->find($id)) {
            return CliPrinter::error("Charity with this id: $id does not exist");
        };

        $this->charity->destroy($id);
        CliPrinter::message("Charity successfully deleted");
    }

    private function find($id)
    {
        return $this->charity->find($id);
    }
}
