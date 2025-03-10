<?php

namespace App\Handlers;

use App\Helpers\Button;
use App\Helpers\Menu;
use App\Helpers\State;
use App\Services\YoutubeService;
use PDO;
use SergiX44\Nutgram\Nutgram;

class MessageHandler
{
    public static function register(Nutgram $bot, PDO $db)
    {
        $bot->onMessage(function (Nutgram $bot) use ($db) {
            if (!$bot->userId()) return;

            $screen = State::getScreen($bot);
            switch ($screen) {
                case State::PRIVACY:
                    Menu::showPrivacyMenu($bot);
                    break;
                case State::GENDER:
                    Menu::showGenderMenu($bot);
                    break;
                case State::MAIN;
                    switch ($bot->message()->text) {
                        case Button::ABOUT:
                            Menu::showAboutMenu($bot);
                            break;
                        case Button::PREMIUM:
                            Menu::showPremiumMenu($bot);
                            break;
                        case Button::GROUP:
                            Menu::showGroupMenu($bot);
                            break;
                        default:
                            self::urlHandler($bot, $bot->message()->text);
                            break;
                    }
            }
        });
    }

    public static function urlHandler(Nutgram $bot, string $text)
    {
        $pattern = '/(https?:\/\/(?:www\.)?(tiktok\.com|likee\.com|like\.com|pinterest\.com|instagram\.com|youtube\.com|youtu\.be)\/[^\s]+)/i';

        return preg_replace_callback($pattern, function ($match) {
            $url = $match[0];
            $domain = strtolower($match[2]);

            switch (true) {
                case strpos($domain, 'youtube') !== false || strpos($domain, 'youtu.be') !== false:
                    YoutubeService::getVideoInfo($bot, $url);

                default:
                    return $url;
            }
        }, $text);
    }
}
