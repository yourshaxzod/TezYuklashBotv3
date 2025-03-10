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
    public static function register(Nutgram $bot)
    {
        $bot->onMessage(function (Nutgram $bot) {
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

    public static function urlHandler(Nutgram $bot, string $text): void
    {
        $pattern = '/(https?:\/\/(?:www\.)?(tiktok\.com|likee\.com|like\.com|pinterest\.com|instagram\.com|youtube\.com|youtu\.be)\/[^\s]+)/i';

        if (preg_match($pattern, $text, $matches)) {
            $url = $matches[0];
            $domain = strtolower($matches[2]);

            switch (true) {
                case strpos($domain, 'youtube') !== false || strpos($domain, 'youtu.be') !== false:
                    YoutubeService::getVideoInfo($bot, $url);
                    break;

                case strpos($domain, 'tiktok') !== false:
                    $bot->sendMessage("TikTok URL detected. This feature is coming soon.");
                    break;

                case strpos($domain, 'instagram') !== false:
                    $bot->sendMessage("Instagram URL detected. This feature is coming soon.");
                    break;

                case strpos($domain, 'likee') !== false || strpos($domain, 'like.com') !== false:
                    $bot->sendMessage("Likee URL detected. This feature is being fixed.");
                    break;

                case strpos($domain, 'pinterest') !== false:
                    $bot->sendMessage("Pinterest URL detected. This feature is being fixed.");
                    break;

                default:
                    $bot->sendMessage("Unsupported URL format. Please try a different link.");
                    break;
            }
        } else {
            if (strlen($text) > 3) {
                $bot->sendMessage("🔍 Qo'shiq qidirilmoqda...");
            }
        }
    }
}
