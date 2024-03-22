<?php

namespace src;

class CliPrinter
{
    public static function message($message)
    {
        fwrite(STDOUT, "\n");
        fwrite(STDOUT, $message);
        fwrite(STDOUT, "\n");
    }
    public static function error($message){
        fwrite(STDOUT, "\n");
        fwrite(STDERR, 'ERROR: '.$message);
        fwrite(STDOUT, "\n");

    }
}
