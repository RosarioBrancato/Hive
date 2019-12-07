<?php


namespace Model;


use DTO\DocumentField;

class DocumentFieldModel extends _Model
{
    private $agentId;

    public function __construct($agentId)
    {
        parent::__construct();

        if(empty($agentId)) {
            $agentId = -1;
        }
        $this->agentId = $agentId;
    }

    public function get(int $id)
    {
        if(empty($id)) {
            $id = -1;
        }

        $query = 'SELECT f.* FROM documentfield f JOIN documenttype t ON t.id = f.documenttypeid WHERE f.id = :id AND t.agentid = :agentId';
        $parameters = [
            ':id' => $id,
            ':agentId' => $this->agentId
        ];

        $array = $this->executeQuerySelect($query, $parameters, "DTO\DocumentField");
        if (isset($array) && sizeof($array) > 0) {
            return $array[0];
        }
    }

    public function getNextFreeNumber()
    {
        $query = 'SELECT f.number FROM documentfield f JOIN documenttype t ON t.id = f.documenttypeid WHERE t.agentid = :agentId ORDER BY f.number DESC LIMIT 1';
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

    public function isLabelUnique($label, $exceptId = -1)
    {
        $query = 'SELECT COUNT(f.id) as count FROM documentfield f JOIN documenttype t ON t.id = f.documenttypeid WHERE t.agentid = :agentId AND f.id <> :exceptId AND f.label = :label';
        $parameters = [
            ':label' => $label,
            ':agentId' => $this->agentId,
            ':exceptId' => $exceptId
        ];

        $array = $this->executeQuerySelect($query, $parameters);

        $isUnique = true;
        if (isset($array) && sizeof($array) > 0 && $array[0]->count > 0) {
            $isUnique = false;
        }

        return $isUnique;
    }

    public function getAll()
    {
        //$query = 'SELECT f.* FROM documentfield f JOIN documenttype t ON t.id = f.documenttypeid  WHERE t.agentid = :agentId ORDER BY f.number';
        $query = 'SELECT f.id, f.number, f.label, f.fieldtype, t.number as documenttypenr, t.name as documenttype FROM documentfield f JOIN documenttype t ON t.id = f.documenttypeid WHERE t.agentid = :agentId ORDER BY t.number, f.number';
        $parameters = [
            ':agentId' => $this->agentId
        ];

        return $this->executeQuerySelect($query, $parameters);
    }

    public function add(DocumentField $documentField): bool
    {
        $success = false;

        $query = 'INSERT INTO documentfield (number, label, fieldtype, documenttypeid) VALUES (:number, :label, :fieldtype, :documenttypeid)';
        $parameters = [
            ':number' => $documentField->getNumber(),
            ':label' => $documentField->getLabel(),
            ':fieldtype' => $documentField->getFieldType(),
            ':documenttypeid' => $documentField->getDocumentTypeId()
        ];

        $newId = $this->executeQueryInsert($query, $parameters);

        if (isset($newId)) {
            $documentField->setId($newId);
            $success = true;
        }

        return $success;
    }

    public function edit(DocumentField $documentField): bool
    {
        $query = 'UPDATE documenttype SET number = :number, label = :label WHERE id = :id and documenttypeid = :documenttypeid';
        $parameters = [
            ':number' => $documentField->getNumber(),
            ':name' => $documentField->getName(),
            ':id' => $documentField->getId(),
            ':agentId' => $documentField->getAgentId(),
        ];

        return $this->executeQuery($query, $parameters);
    }

}