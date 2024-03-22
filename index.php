<?php

require 'autoload.php';

use src\App;
use src\Commands;
use src\controllers\DonationController;
use src\controllers\CharityController;
use src\MariaDbConfig;



define("ENV", __DIR__ . "/.env");
define('CSVlocation', __DIR__ . '/csv/' );

$commands = new Commands($argv);

$commands->registerCommand('charities', [CharityController::class, 'findAll'], 'To see all charities run: php index.php charities');
$commands->registerCommand('create', [CharityController::class, 'store'], 'To create new charity run: php index.php create ["Charity name"] [email address]');
$commands->registerCommand('csv', [CharityController::class, 'csv'], 'To upload charities from csv your file must be in csv folder, run: php index.php csv ["file name.csv"]');
$commands->registerCommand('edit', [CharityController::class, 'update'], 'To edit existing charity run: php index.php edit [charity id] ["New charity name"] [new email address]');
$commands->registerCommand('delete', [CharityController::class, 'destroy'], 'To delete charity run: php index.php delete [charity id]');
$commands->registerCommand('donate', [DonationController::class, 'add'], 'To make a donation to charity run: php index.php donate [charity id] [amount] ["Donator name"]');

$mariaDbConfig = (new MariaDbConfig())->mariaDbConfig();


$app = (new App($commands, $argv))->connectDb($mariaDbConfig)->run();
