<?php

namespace App\Helpers;

use App\Config\Config;
use SergiX44\Nutgram\Nutgram;

class Validator
{
    public static function isAdmin(Nutgram $bot): bool
    {
        $adminIds = Config::getAdminIds();
        return in_array($bot->userId(), $adminIds, true);
    }
}
