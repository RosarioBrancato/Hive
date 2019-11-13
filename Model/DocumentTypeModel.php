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

    public function getAll()
    {
        $query = 'SELECT * FROM documenttype WHERE agentid = :agentId';
        $parameters = [
            ':agentId' => $this->agentId
        ];

        return $this->executeQuerySelect($query, $parameters, "DTO\DocumentType");
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

    public function add(DocumentType $documentType): bool
    {
        $success = false;

        $query = 'INSERT INTO documenttype (name, agentid) VALUES (:name, :agentId)';
        $parameters = [
            ':agentId' => $documentType->getAgentId(),
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
        $query = 'UPDATE documenttype SET name = :name WHERE id = :id and agentid = :agentId';
        $parameters = [
            ':id' => $documentType->getId(),
            ':agentId' => $documentType->getAgentId(),
            ':name' => $documentType->getName()
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