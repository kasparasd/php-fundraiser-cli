<?php

namespace src\validations;

class CharityValidation
{
    public static function inputs($inputs)
    {
        if ($inputs[1] === 'create' || $inputs[1] === 'excel') {
            if (count($inputs) < 4) {
                return false;
            }
            if (count($inputs) > 4) {
                return false;
            }
        } else if ($inputs[1] === 'edit') {
            if (count($inputs) < 5) {
                return false;
            }
            if (count($inputs) > 5) {
                return false;
            }
        }
        return true;
    }
    public static function email($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
    public static function name($name)
    {
        if (strlen($name) < 8) {
            return false;
        }
        if (strlen($name) > 50) {
            return false;
        }
        return true;
    }
}
