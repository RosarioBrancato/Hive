<?php


namespace Model;


use Config\Config;
use PDO;
use PDOStatement;

class _Model
{
    private $pdo = null;

    public function __construct()
    {
        $this->initPDO();
    }

    protected function getPDO(): PDO
    {
        return $this->pdo;
    }

    protected function executeQuery(string $query, array $parameters): bool
    {
        $stmt = $this->getStatement($query, $parameters);
        return $this->executeStatement($stmt);
    }

    protected function executeQueryInsert(string $query, array $parameters): int
    {
        $stmt = $this->getStatement($query, $parameters);
        $this->executeStatement($stmt);

        return $this->getPDO()->lastInsertId();
    }

    protected function executeQuerySelect(string $query, array $parameters, string $classType = null): array
    {
        $stmt = $this->getStatement($query, $parameters);
        $this->executeStatement($stmt);

        if ($stmt->rowCount() > 0) {
            if (isset($classType)) {
                $array = $stmt->fetchAll(\PDO::FETCH_CLASS, $classType);
            } else {
                $array = $stmt->fetchAll(\PDO::FETCH_CLASS);
            }
        }

        if (!isset($array)) {
            $array = [];
        }

        return $array;
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

    private function getStatement(string $query, array $parameters): PDOStatement
    {
        $stmt = $this->getPDO()->prepare($query);

        foreach ($parameters as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        return $stmt;
    }

    private function executeStatement(PDOStatement $stmt): bool
    {
        return $stmt->execute();
    }

}