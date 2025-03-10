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
        self::sendMenu($bot, "🍿", Keyboard::RemoveKeyboard());
        self::sendMenu($bot, Message::PrivacyMenu(), Keyboard::PrivacyMenu());
    }

    public static function showGenderMenu(Nutgram $bot)
    {
        State::setScreen($bot, State::GENDER);
        self::sendMenu($bot, Message::GenderMenu(), Keyboard::GenderMenu());
    }

    public static function showAboutMenu(Nutgram $bot)
    {
        self::sendMenu($bot, Message::AboutMenu(), Keyboard::MainMenu($bot));
    }

    public static function showPremiumMenu(Nutgram $bot)
    {
        self::sendMenu($bot, Message::PremiumMenu(), Keyboard::MainMenu($bot));
    }

    public static function showGroupMenu(Nutgram $bot)
    {
        self::sendMenu($bot, Message::GroupMenu(), Keyboard::MainMenu($bot));
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
