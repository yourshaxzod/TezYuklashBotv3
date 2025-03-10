<?php

namespace App\Config;

use App\Config\Config;
use PDO;

class Database
{
    public static function connectDatabase()
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ];

        $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8mb4", Config::get('DB_HOST'), Config::get('DB_NAME'));

        $pdo = new PDO($dsn, Config::get('DB_USER'), Config::get('DB_PASSWORD'), $options);

        return $pdo;
    }
}
