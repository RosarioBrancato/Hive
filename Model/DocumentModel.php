<?php


namespace Model;


use DTO\Document;
use DTO\DocumentFieldValue;
use DTO\DocumentFile;
use PDO;

class DocumentModel extends _Model
{

    public function getAll()
    {
        $query = 'SELECT d.*, dt.name as documenttypename 
                    FROM document d 
                    LEFT JOIN documenttype dt ON dt.id = d.documenttypeid 
                    WHERE d.agentid = :agentId 
                    ORDER BY d.created desc';

        $parameters = [
            ':agentId' => $this->getAgentId()
        ];

        return $this->executeQuerySelect($query, $parameters);
    }

    /**
     * @param $document Document
     * @param $documentFiles DocumentFile[]
     * @param $documentFieldValues DocumentFieldValue[]
     * @return bool
     */
    public function add($document, $documentFiles, $documentFieldValues)
    {
        $this->getPDO()->beginTransaction();

        //insert document
        $query = 'INSERT INTO document (title, created, documenttypeid, agentid) VALUES (:title, NOW(), :documenttypeid, :agentid)';
        $parameters = [
            ':title' => $document->getTitle(),
            ':documenttypeid' => $document->getDocumenttypeid(),
            ':agentid' => $this->getAgentId()
        ];

        $newId = $this->executeQueryInsert($query, $parameters);
        $success = !empty($newId);

        if ($success) {
            $document->setId($newId);
        }

        //insert document files
        if ($success) {
            foreach ($documentFiles as $documentFile) {
                $query = 'INSERT INTO documentfile (documentid, filename, filecontent) VALUES (:documentid, :filename, :filecontent)';
                $parameters = [
                    ':documentid' => $document->getId(),
                    ':filename' => $documentFile->getFilename(),
                    ':filecontent' => $documentFile->getFilecontent()
                ];

                $newId = $this->executeQueryInsert($query, $parameters);
                $success = !empty($newId);

                if ($success) {
                    $documentFile->setId($newId);
                }
            }
        }

        //insert document fields
        if ($success && !empty($documentFieldValues)) {
            foreach ($documentFieldValues as $documentFieldValue) {
                $query = 'INSERT INTO documentfieldvalue (documentid, number, label, fieldtype, stringvalue, intvalue, decimalvalue, boolvalue, datevalue) 
                            VALUES (:documentid, :number, :label, :fieldtype, :stringvalue, :intvalue, :decimalvalue, :boolvalue, :datevalue)';
                $parameters = [
                    ':documentid' => $document->getId(),
                    ':number' => $documentFieldValue->getNumber(),
                    ':label' => $documentFieldValue->getLabel(),
                    ':fieldtype' => $documentFieldValue->getFieldType(),
                    ':stringvalue' => $documentFieldValue->getStringValue(),
                    ':intvalue' => $documentFieldValue->getIntValue(),
                    ':decimalvalue' => $documentFieldValue->getDecimalValue(),
                    ':boolvalue' => $documentFieldValue->getBoolValue(),
                    ':datevalue' => $documentFieldValue->getDatevalue()
                ];

                $newId = $this->executeQueryInsert($query, $parameters);
                $success = !empty($newId);

                if ($success) {
                    $documentFieldValue->setId($newId);
                }
            }
        }

        if ($success) {
            $this->getPDO()->commit();
        } else {
            $this->getPDO()->rollBack();
        }

        return $success;
    }

}