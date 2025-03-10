<?php

namespace App\Config;

use Dotenv\Dotenv;

class Config
{
    private static bool $loaded = false;

    public static function load(): void
    {
        if (self::$loaded) {
            return;
        }

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $dotenv->required([
            'BOT_TOKEN'
        ]);

        self::$loaded = true;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        self::load();
        return self::$cache[$key] ?? $_ENV[$key] ?? $default;
    }

    public static function isDebugMode(): bool
    {
        return self::get('DEBUG_MODE', false);
    }

    public static function getAdminIds(): array
    {
        $ids = self::get('ADMIN_IDS', '');
        return array_map('intval', array_filter(explode(',', $ids)));
    }
}
