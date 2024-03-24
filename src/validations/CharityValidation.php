<?php

namespace src\validations;

class CharityValidation
{
    public static function hasValidInputCount($inputs, $expectedInputsCount)
    {
        if (count($inputs) !== $expectedInputsCount) {
            return false;
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
    public static function hasValidNameLength($name, $minLength, $maxLength)
    {
        $nameLength = strlen($name);
        if ($nameLength < $minLength || $nameLength > $maxLength) {
            return false;
        }

        return true;
    }
}
