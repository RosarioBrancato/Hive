<?php


namespace Model;


use DTO\DocumentField;

class DocumentFieldModel extends _Model
{

    public function get(int $id)
    {
        if (empty($id)) {
            $id = -1;
        }

        $query = 'SELECT f.* FROM documentfield f JOIN documenttype t ON t.id = f.documenttypeid WHERE f.id = :id AND t.agentid = :agentId';
        $parameters = [
            ':id' => $id,
            ':agentId' => $this->getAgentId()
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
            ':agentId' => $this->getAgentId()
        ];

        $array = $this->executeQuerySelect($query, $parameters);

        $nextNumber = 0;
        if (isset($array) && sizeof($array) > 0) {
            $nextNumber = $array[0]->number;
        }
        $nextNumber = $nextNumber + 1;

        return $nextNumber;
    }

    public function isLabelUnique($label, $documentTypeId, $exceptId = -1)
    {
        $query = 'SELECT COUNT(f.id) as count 
                    FROM documentfield f 
                    JOIN documenttype t ON t.id = f.documenttypeid 
                    WHERE t.agentid = :agentId 
                        AND f.id <> :exceptId 
                        AND f.label = :label
                        AND f.documenttypeid = :documenttypeid';

        $parameters = [
            ':label' => $label,
            ':documenttypeid' => $documentTypeId,
            ':agentId' => $this->getAgentId(),
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
        $query = 'SELECT f.id, f.number, f.label, f.fieldtype, t.number as documenttypenr, t.name as documenttype FROM documentfield f JOIN documenttype t ON t.id = f.documenttypeid WHERE t.agentid = :agentId ORDER BY t.number, f.number';
        $parameters = [
            ':agentId' => $this->getAgentId()
        ];

        return $this->executeQuerySelect($query, $parameters);
    }

    public function getAllByDocumentTypeId($documenttypeid)
    {
        $query = 'SELECT *
                    FROM documentfield
                    WHERE documenttypeid = :documenttypeid
                    ORDER BY number';

        $parameters = [
            ':documenttypeid' => $documenttypeid
        ];

        return $this->executeQuerySelect($query, $parameters, 'DTO\DocumentField');
    }

    public function getAllForStatistics()
    {
        $query = "SELECT df.label, df.fieldtype
                    FROM documentfield df
                    JOIN documenttype dt ON dt.id = df.documenttypeid
                    WHERE dt.agentid = :agentid
                        AND df.fieldtype IN (2, 3, 4)
                    GROUP BY df.label, df.fieldtype
                    ORDER BY df.label, df.fieldtype";

        $parameters = [
            ':agentid' => $this->getAgentId()
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

        if (!empty($newId)) {
            $documentField->setId($newId);
            $success = true;
        }

        return $success;
    }

    public function edit(DocumentField $documentField): bool
    {
        $query = 'UPDATE documentfield SET number = :number, label = :label, fieldtype = :fieldtype, documenttypeid = :documenttypeid WHERE id = :id';
        $parameters = [
            ':number' => $documentField->getNumber(),
            ':label' => $documentField->getLabel(),
            ':id' => $documentField->getId(),
            ':fieldtype' => $documentField->getFieldType(),
            ':documenttypeid' => $documentField->getDocumentTypeId()
        ];

        return $this->executeQuery($query, $parameters);
    }

    public function delete(int $id): bool
    {
        $query = 'DELETE FROM documentfield WHERE id = :id';
        $parameters = [
            ':id' => $id
        ];

        return $this->executeQuery($query, $parameters);
    }

    public function checkAgentId(int $id): bool
    {
        if (empty($id)) {
            $id = -1;
        }

        $query = 'SELECT agentid FROM documentfield f JOIN documenttype t on t.id = f.documenttypeid WHERE f.id = :id';
        $parameters = [
            ':id' => $id
        ];

        $array = $this->executeQuerySelect($query, $parameters);

        $isValid = false;
        if (!empty($array)) {
            $isValid = $array[0]->agentid == $this->getAgentId();
        }

        return $isValid;
    }

}