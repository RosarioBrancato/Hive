<?php


namespace Database;


use PDO;

class DbAccess
{

    public static function GetPDO()
    {
        try {
            $dsn = getenv('DATABASE_URL2');
            return new PDO($dsn);

        } catch (\Exception $ex) {
            error_log($ex);

            $config = simplexml_load_file('Config/Hive.config.xml');

            $host = $config->Database->Host;
            $port = $config->Database->Port;
            $db = $config->Database->Name;
            $db_user = $config->Database->UserName;
            $db_pw = $config->Database->Password;

            $dsn = "pgsql:host=$host;port=$port;dbname=$db;user=$db_user;password=$db_pw";

            return new PDO($dsn);
        }
    }

}