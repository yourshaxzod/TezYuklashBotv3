<?php

namespace App\Handlers;

use App\Helpers\Keyboard;
use App\Helpers\Menu;
use App\Helpers\Message;
use App\Helpers\State;
use App\Models\User;
use PDO;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

class CallbackHandler
{
    public static function register(Nutgram $bot, PDO $db)
    {
        self::registerCallbacks($bot, $db);
    }

    public static function registerCallbacks(Nutgram $bot, PDO $db)
    {
        $bot->onCallbackQueryData('agree', function (Nutgram $bot) {
            State::setScreen($bot, State::GENDER);
            State::set($bot, 'privacy', 'agree');
            $bot->editMessageText(
                chat_id: $bot->userId(),
                message_id: $bot->message()->message_id,
                text: Message::GenderMenu(),
                parse_mode: ParseMode::HTML,
                reply_markup: Keyboard::GenderMenu()
            );
        });

        $bot->onCallbackQueryData('gender {data}', function (Nutgram $bot, $data) use ($db) {
            $bot->deleteMessage($bot->chat()->id, $bot->message()->message_id);
            Menu::showMainMenu($bot);

            User::update($db, $bot->userId(), [
                'privacy' => State::get($bot, 'privacy'),
                'gender' => $data
            ]);
        });
    }
}
