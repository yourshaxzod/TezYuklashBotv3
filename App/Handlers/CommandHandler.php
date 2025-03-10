<?php

namespace App\Handlers;

use App\Helpers\Menu;
use App\Models\User;
use PDO;
use SergiX44\Nutgram\Nutgram;

class CommandHandler
{
    public static function register(Nutgram $bot, PDO $db)
    {
        self::registerCommands($bot, $db);
    }

    public static function registerCommands(Nutgram $bot, PDO $db)
    {
        $bot->onCommand('start', function (Nutgram $bot, PDO $db) {
            $chat_type = $bot->chat()->type;
            if ($chat_type == "private") {
                $user = User::register($db, $bot);
                if (!$user) {
                    Menu::showPrivacyMenu($bot);
                } else {
                    Menu::showMainMenu($bot);
                }
            }
        });
    }
}
