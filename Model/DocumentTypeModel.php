<?php


namespace Model;


use DTO\DocumentType;

class DocumentTypeModel extends _Model
{
    private $agentId;

    public function __construct($agentId)
    {
        parent::__construct();
        $this->agentId = $agentId;
    }

    public function get(int $id)
    {
        $query = 'SELECT * FROM documenttype WHERE id = :id AND agentid = :agentId';
        $parameters = [
            ':id' => $id,
            ':agentId' => $this->agentId
        ];

        $array = $this->executeQuerySelect($query, $parameters, "DTO\DocumentType");
        if (isset($array) && sizeof($array) > 0) {
            return $array[0];
        }
    }

    public function getNextFreeNumber() {
        $query = 'SELECT number FROM documenttype WHERE agentid = :agentId ORDER BY number DESC LIMIT 1';
        $parameters = [
            ':agentId' => $this->agentId
        ];

        $array = $this->executeQuerySelect($query, $parameters);

        $nextNumber = 0;
        if (isset($array) && sizeof($array) > 0) {
            $nextNumber = $array[0]->number;
        }
        $nextNumber = $nextNumber + 1;

        return $nextNumber;
    }

    public function isNameUnique($name, $exceptId = -1) {
        $query = 'SELECT COUNT(id) as count FROM documenttype WHERE agentid = :agentId AND id <> :exceptId AND name = :name';
        $parameters = [
            ':name' => $name,
            ':agentId' => $this->agentId,
            ':exceptId' => $exceptId
        ];

        $array = $this->executeQuerySelect($query, $parameters);
        var_dump($array);

        $isUnique = true;
        if (isset($array) && sizeof($array) > 0 && $array[0]->count > 0) {
            $isUnique = false;
        }

        return $isUnique;
    }

    public function getAll()
    {
        $query = 'SELECT * FROM documenttype WHERE agentid = :agentId ORDER BY number';
        $parameters = [
            ':agentId' => $this->agentId
        ];

        return $this->executeQuerySelect($query, $parameters, "DTO\DocumentType");
    }

    public function add(DocumentType $documentType): bool
    {
        $success = false;

        $query = 'INSERT INTO documenttype (number, name, agentid) VALUES (:number, :name, :agentId)';
        $parameters = [
            ':agentId' => $documentType->getAgentId(),
            ':number' => $documentType->getNumber(),
            ':name' => $documentType->getName()
        ];

        $newId = $this->executeQueryInsert($query, $parameters);

        if (isset($newId)) {
            $documentType->setId($newId);
            $success = true;
        }

        return $success;
    }

    public function edit(DocumentType $documentType): bool
    {
        $query = 'UPDATE documenttype SET number = :number, name = :name WHERE id = :id and agentid = :agentId';
        $parameters = [
            ':number' => $documentType->getNumber(),
            ':name' => $documentType->getName(),
            ':id' => $documentType->getId(),
            ':agentId' => $documentType->getAgentId(),
        ];

        return $this->executeQuery($query, $parameters);
    }

    public function delete(int $id): bool
    {
        $query = 'DELETE FROM documenttype WHERE id = :id AND agentid = :agentId';
        $parameters = [
            ':id' => $id,
            ':agentId' => $this->agentId
        ];

        return $this->executeQuery($query, $parameters);
    }
}