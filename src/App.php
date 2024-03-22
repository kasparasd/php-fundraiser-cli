<?php

namespace src;

class App
{
    private static Db $db;

    public function __construct(private Commands $commands, private array $argv)
    {
    }

    public function run()
    {
        if (count($this->argv) <= 1 || $this->argv[1] === 'help') {
            return $this->help();
        }

        if ($this->argv[1] === 'db') {
            return CreateTables::create();
        }
        return $this->commands->runCommand();
    }

    public function help()
    {
        foreach ($this->commands->getRegistry() as $value) {
            $explanationMessage = $value[2];
            CliPrinter::message($explanationMessage);
        }
    }

    public function connectDb($config)
    {
        static::$db = (new Db($config));
        return $this;
    }

    public static function db()
    {
        return static::$db;
    }
}
