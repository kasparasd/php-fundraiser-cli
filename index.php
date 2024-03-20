<?php

require 'autoload.php';

use App\App;
use App\Commands;
use App\controllers\DonationController;
use App\controllers\CharityController;
use App\MariaDbConfig;

$env = __DIR__ . "/.env";

$commands = new Commands($argv);

$commands->registerCommand('charities', [CharityController::class, 'findAll'], 'To see all charities run: php index.php charities');
$commands->registerCommand('create', [CharityController::class, 'store'], 'To create new charity run: php index.php create [Charity_name] [email address]');
$commands->registerCommand('edit', [CharityController::class, 'update'], 'To edit existing charity run: php index.php edit [charity id] [new_charity_name] [new email address]');
$commands->registerCommand('delete', [CharityController::class, 'destroy'], 'To delete charity run: php index.php delete [charity id]');
$commands->registerCommand('donate', [DonationController::class, 'add'], 'To make a donation to charity run: php index.php donate [charity id] [amount] [Donator_name]');

$mariaDbConfig = (new MariaDbConfig($env))->mariaDbConfig();


$app = (new App($commands, $argv))->connectDb($mariaDbConfig)->run();
