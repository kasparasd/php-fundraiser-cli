<?php

namespace src;

class Commands
{
    private $registry = [];

    public function __construct(private array $argv = [])
    {
        $this->registerCommand('db', ['', ''], 'To create DB tables run: php index.php db');
        $this->registerCommand('help', ['', ''], 'To see all available commands run: php index.php help');
    }

    public function registerCommand($command, $params, $helpMessage)
    {
        return $this->registry[$command] = [$params[0], $params[1], $helpMessage];
    }

    public function getCommand($command)
    {
        return isset($this->registry[$command]) ? $this->registry[$command] : null;
    }

    public function runCommand()
    {
        $argv = $this->argv;
        $command_name = "help";

        if (isset($argv[1])) {
            $command_name = $argv[1];
        }

        $command = $this->getCommand($command_name);
        if ($command === null) {
            CliPrinter::error("ERROR: Command \"$command_name\" not found. To check available commands run: php index.php help ");
            exit;
        }

        if (method_exists($this, $command_name)) {
            return $this->$command_name();
        }

        $controllerClass = $command[0];
        $method = $command[1];

        $controller = new $controllerClass($argv);
        return $controller->$method();
    }

    public function getRegistry()
    {
        return $this->registry;
    }
}
