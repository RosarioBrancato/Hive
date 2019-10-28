<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 22.09.2017
 * Time: 14:56
 */

namespace Config;

class Config
{
    protected static $iniFile = "Config/Hive.config.env";
    protected static $config = [];

    public static function init()
    {
        if (file_exists(self::$iniFile)) {
            self::$config = parse_ini_file(self::$iniFile);
        } else if (file_exists("../" . self::$iniFile)) {
            self::$config = parse_ini_file("../" . self::$iniFile);
        } else {
            self::loadENV();
        }

        self::$config["database.dsn"] = "pgsql:host=" . self::$config["database.host"]
            . ";port=" . self::$config["database.port"]
            . ";dbname=" . self::$config["database.name"]
            . ";user=" . self::$config["database.user"]
            . ";password=" . self::$config["database.password"];
    }

    public static function get($key)
    {
        if (empty(self::$config))
            self::init();
        return self::$config[$key];
    }

    private static function loadENV()
    {
        if (isset($_ENV["DATABASE_URL"])) {
            $dbopts = parse_url($_ENV["DATABASE_URL"]);

            self::$config["database.host"] = $dbopts["host"];
            self::$config["database.port"] = $dbopts["port"];
            self::$config["database.name"] = ltrim($dbopts["path"], '/');
            self::$config["database.user"] = $dbopts["user"];
            self::$config["database.password"] = $dbopts["pass"];
        }
        /*
        if (isset($_ENV["SENDGRID_APIKEY"])) {
            self::$config["email.sendgrid-apikey"] = $_ENV["SENDGRID_APIKEY"];
        }
        if (isset($_ENV["HYPDF_USER"])) {
            self::$config["pdf.hypdf-user"] = $_ENV["HYPDF_USER"];
        }
        if (isset($_ENV["HYPDF_PASSWORD"])) {
            self::$config["pdf.hypdf-password"] = $_ENV["HYPDF_PASSWORD"];
        }
        */
    }
}