<?php

namespace App\Helpers;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

class Menu
{
    public static function showMainMenu(Nutgram $bot)
    {
        State::setScreen($bot, State::MAIN);
        self::sendMenu($bot, Message::MainMenu(), Keyboard::MainMenu($bot));
    }

    public static function showPrivacyMenu(Nutgram $bot)
    {
        State::setScreen($bot, State::PRIVACY);
        self::sendMenu($bot, Message::PrivacyMenu(), Keyboard::PrivacyMenu());
    }

    public static function showGenderMenu(Nutgram $bot)
    {
        State::setScreen($bot, State::GENDER);
        self::sendMenu($bot, Message::GenderMenu(), Keyboard::GenderMenu());
    }

    public static function sendMenu(Nutgram $bot, $text, $keyboard = null)
    {
        $bot->sendMessage(
            text: $text,
            parse_mode: ParseMode::HTML,
            reply_markup: $keyboard
        );
    }
}
