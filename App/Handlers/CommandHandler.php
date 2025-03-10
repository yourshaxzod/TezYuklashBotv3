<?php

namespace App\Handlers;

use App\Helpers\Menu;
use App\Helpers\State;
use App\Models\User;
use PDO;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ChatType;

class CommandHandler
{
    public static function register(Nutgram $bot, PDO $db)
    {
        self::registerCommands($bot, $db);
    }

    public static function registerCommands(Nutgram $bot, PDO $db)
    {
        $bot->onCommand('start', function (Nutgram $bot) use ($db) {
            $screen = State::getScreen($bot);
            $chat_type = $bot->chat()->type;

            if ($chat_type == ChatType::PRIVATE) {
                if (!$screen | $screen == State::MAIN) {
                    $user = User::register($db, $bot);
                    if (!$user) {
                        Menu::showPrivacyMenu($bot);
                    } else {
                        Menu::showMainMenu($bot);
                    }
                } else if ($screen == State::PRIVACY) {
                    Menu::showPrivacyMenu($bot);
                } else if ($screen == State::GENDER) {
                    Menu::showGenderMenu($bot);
                }
            }
        });
    }
}
