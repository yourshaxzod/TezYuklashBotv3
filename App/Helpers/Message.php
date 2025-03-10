<?php

namespace App\Helpers;

class Message
{
    public static function MainMenu()
    {
        $message = "<b>👋 Assalomu alaykum, xavola yuboring.</b>";
        return $message;
    }

    public static function PrivacyMenu()
    {
        $message = "<b>Qoidalarga rozimisiz?</b>";
        return $message;
    }

    public static function GenderMenu()
    {
        $message = "<b>Jinsingizni tanlang:</b>";
        return $message;
    }
}
