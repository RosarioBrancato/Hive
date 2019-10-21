<?php


namespace Model;


use Database\DbAccess;

class _Model
{
    private $pdo = null;

    public function __construct()
    {
        $this->pdo = DbAccess::GetPDO();
    }

    protected function getPDO()
    {
        return $this->pdo;
    }

}