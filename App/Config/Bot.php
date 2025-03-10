<?php

namespace App\Config;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Polling;
use App\Config\Config;

class Bot
{
    public static function createBot(): Nutgram
    {
        $token = Config::get('BOT_TOKEN');

        $bot = new Nutgram($token);
        $bot->setRunningMode(Polling::class);

        return $bot;
    }
}
