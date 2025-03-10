<?php

namespace App\Helpers;

use App\Helpers\Button;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove;

class Keyboard
{
    public static function MainMenu($bot): ReplyKeyboardMarkup
    {
        $keyboard = ReplyKeyboardMarkup::make(resize_keyboard: true);
        $keyboard->addRow(
            KeyboardButton::make(Button::ABOUT),
            KeyboardButton::make(Button::PREMIUM),
            KeyboardButton::make(Button::GROUP)
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
            InlineKeyboardButton::make(Button::AGREE, callback_data: "agree"),
        );
        return $keyboard;
    }

    public static function GenderMenu(): InlineKeyboardMarkup
    {
        $keyboard = InlineKeyboardMarkup::make();
        $keyboard->addRow(
            InlineKeyboardButton::make(Button::MALE, callback_data: "gender male"),
            InlineKeyboardButton::make(Button::FEMALE, callback_data: "gender female")
        );
        return $keyboard;
    }

    public static function RemoveKeyboard(): ReplyKeyboardRemove
    {
        return ReplyKeyboardRemove::make(remove_keyboard: true);
    }
}
