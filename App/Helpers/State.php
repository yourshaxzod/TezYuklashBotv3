<?php

namespace App\Helpers;

use SergiX44\Nutgram\Nutgram;
use PDO;

class State
{
    public const STATE = 'state';
    public const SCREEN = 'screen';

    // SCREENS
    public const MAIN = 'main';
    public const PRIVACY = 'privacy';
    public const GENDER = 'gender';

    public static function get(Nutgram $bot, string $key = 'state')
    {
        global $db;

        $userId = $bot->userId();
        if (!$userId) return null;

        $stmt = $db->prepare("SELECT data FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result || empty($result['data'])) {
            return null;
        }

        $data = json_decode($result['data'], true) ?? [];
        return $data[$key] ?? null;
    }

    public static function set(Nutgram $bot, string $key, mixed $value)
    {
        global $db;

        $userId = $bot->userId();
        if (!$userId) return false;

        $stmt = $db->prepare("SELECT data FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $data = [];
        if ($result && !empty($result['data'])) {
            $data = json_decode($result['data'], true) ?? [];
        }

        $data[$key] = $value;

        $stmt = $db->prepare("UPDATE users SET data = ?, updated_at = NOW() WHERE user_id = ?");
        $success = $stmt->execute([json_encode($data), $userId]);

        return $success;
    }

    public static function clear(Nutgram $bot, ?array $keys = null)
    {
        global $db;

        $userId = $bot->userId();
        if (!$userId) return false;

        $stmt = $db->prepare("SELECT data FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result || empty($result['data'])) {
            return true;
        }

        $data = json_decode($result['data'], true) ?? [];

        if ($keys === null) {
            unset($data['state']);
        } else {
            foreach ($keys as $key) {
                unset($data[$key]);
            }
        }

        $stmt = $db->prepare("UPDATE users SET data = ?, updated_at = NOW() WHERE user_id = ?");
        $success = $stmt->execute([json_encode($data), $userId]);

        return $success;
    }

    public static function clearAll(Nutgram $bot)
    {
        global $db;

        $userId = $bot->userId();
        if (!$userId) return false;

        $stmt = $db->prepare("UPDATE users SET data = NULL, updated_at = NOW() WHERE user_id = ?");
        $success = $stmt->execute([$userId]);

        return $success;
    }

    public static function getState(Nutgram $bot): ?string
    {
        return self::get($bot, self::STATE);
    }

    public static function setState(Nutgram $bot, ?string $value): bool
    {
        return self::set($bot, self::STATE, $value);
    }

    public static function getScreen(Nutgram $bot): ?string
    {
        return self::get($bot, self::SCREEN);
    }

    public static function setScreen(Nutgram $bot, string $screen): bool
    {
        return self::set($bot, self::SCREEN, $screen);
    }

    public static function isInState(Nutgram $bot, string|array $states): bool
    {
        $currentState = self::getState($bot);
        if (is_array($states)) {
            return in_array($currentState, $states);
        }
        return $currentState === $states;
    }
}
