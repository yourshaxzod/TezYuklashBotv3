<?php

namespace App\Helpers;

use App\Helpers\Button;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class Keyboard
{
    public static function MainMenu($bot): ReplyKeyboardMarkup
    {
        $keyboard = ReplyKeyboardMarkup::make(resize_keyboard: true);
        $keyboard->addRow(
            KeyboardButton::make(Button::ABOUT),
            KeyboardButton::make(Button::PREMIUM),
            KeyboardButton::make(Button::TRENDING)
        );
        if (Validator::isAdmin($bot)) {
            $keyboard->addRow(
                KeyboardButton::make(Button::PANEL)
            );
        }
        return $keyboard;
    }

    public static function PrivacyMenu(): InlineKeyboardMarkup
    {
        $keyboard = InlineKeyboardMarkup::make();
        $keyboard->addRow(
            InlineKeyboardButton::make("Roziman"),
            InlineKeyboardButton::make("Rozi emasman")
        );
        return $keyboard;
    }

    public static function GenderMenu(): InlineKeyboardMarkup
    {
        $keyboard = InlineKeyboardMarkup::make();
        $keyboard->addRow(
            InlineKeyboardButton::make("Erkak", callback_data: "gender erkak"),
            InlineKeyboardButton::make("Ayol", callback_data: "gender ayol")
        );
        return $keyboard;
    }
}
