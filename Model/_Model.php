<?php


namespace Model;


use Config\Config;
use PDO;

class _Model
{
    private $pdo = null;

    public function __construct()
    {
        $this->initPDO();
    }

    protected function getPDO()
    {
        return $this->pdo;
    }

    private function initPDO()
    {
        try {
            $dsn = Config::get("database.dsn");
            $this->pdo = new PDO($dsn);

        } catch (\Exception $ex) {
            error_log($ex);
        }
    }

}