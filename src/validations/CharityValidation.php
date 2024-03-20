<?php

namespace App\validations;

use App\CliPrinter;

class CharityValidation
{
    public static function inputs($inputs)
    {
        if ($inputs[1] === 'create') {
            if (count($inputs) < 4) {
                var_dump($inputs);
                CliPrinter::error("Too few arguments inserted, please run: php index.php create [Charity_name] [Email address]");
                return false;
            }
            if (count($inputs) > 4) {
                CliPrinter::error("Too many arguments inserted, please run: php index.php create [Charity_name] [Email address]");
                return false;
            }
        } else if ($inputs[1] === 'edit') {
            if (count($inputs) < 5) {
                var_dump($inputs);
                CliPrinter::error("Too few arguments inserted, please run: php index.php edit [Charity id] [New_charity_name] [New email address]");
                return false;
            }
            if (count($inputs) > 5) {
                CliPrinter::error("Too many arguments inserted, please run: php index.php edit [Charity id] [New_charity_name] [New email address]");
                return false;
            }
        }
        return true;
    }
    public static function email($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            CliPrinter::error("Email is not valid");
            return false;
        }
        return true;
    }
    public static function name($name)
    {
        if (strlen($name) < 8) {
            CliPrinter::error("Charity name should be at least 8 characters long");
            return false;
        }
        if (strlen($name) > 50) {
            CliPrinter::error("Charity name should be no longer than 50 characters");
            return false;
        }
        return true;
    }
}
