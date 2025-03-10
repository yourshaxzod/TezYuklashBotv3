<?php

require_once __DIR__ . "/vendor/autoload.php";

use App\Config\Bot;
use App\Config\Database;
use App\Handlers\CommandHandler;

$bot = Bot::createBot();
$db = Database::connectDatabase();

CommandHandler::register($bot, $db);

$bot->run();
