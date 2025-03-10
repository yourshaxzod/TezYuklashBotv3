<?php

require_once __DIR__ . "/vendor/autoload.php";

use App\Config\Bot;
use App\Config\Database;
use App\Handlers\CallbackHandler;
use App\Handlers\CommandHandler;
use App\Handlers\MessageHandler;

$bot = Bot::createBot();
$db = Database::connectDatabase();

CommandHandler::register($bot, $db);
CallbackHandler::register($bot, $db);
MessageHandler::register($bot, $db);

$bot->run();
