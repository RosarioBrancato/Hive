<?php


namespace Model;


use DTO\Document;
use DTO\DocumentFieldValue;
use DTO\DocumentFile;

class DocumentModel extends _Model
{

    /**
     * @param int $id
     * @return Document|null
     */
    public function get(int $id)
    {
        $query = 'SELECT * FROM document WHERE id = :id AND agentid = :agentid';
        $parameters = [
            ':id' => $id,
            ':agentid' => $this->getAgentId()
        ];

        $array = $this->executeQuerySelect($query, $parameters, 'DTO\Document');
        if (isset($array) && sizeof($array) > 0) {
            return $array[0];
        }
    }

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
            $documentFileModel = new DocumentFileModel($this->getAgentId());
            $documentFileModel->setPDO($this->getPDO());

            foreach ($documentFiles as $documentFile) {
                $documentFile->setDocumentid($document->getId());
                $newId = $documentFileModel->add($documentFile);
                $success &= !empty($newId);

                if ($success) {
                    $documentFile->setId($newId);
                } else {
                    break;
                }
            }
        }

        //insert document field values
        if ($success && !empty($documentFieldValues)) {
            $documentFieldValueModel = new DocumentFieldValueModel($this->getAgentId());
            $documentFieldValueModel->setPDO($this->getPDO());

            foreach ($documentFieldValues as $documentFieldValue) {
                $documentFieldValue->setDocumentid($document->getId());

                $newId = $documentFieldValueModel->add($documentFieldValue);
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


    /**
     * @param $document Document
     * @param $documentFiles DocumentFile[]
     * @param $documentFieldValues DocumentFieldValue[]
     * @return bool
     */
    public function update($document, $documentFiles, $documentFieldValues)
    {
        $this->getPDO()->beginTransaction();

        $documentFieldValueModel = new DocumentFieldValueModel($this->getAgentId());
        $documentFieldValueModel->setPDO($this->getPDO());

        //if document type changed => delete field values
        $documentInternal = $this->get($document->getId());
        if (!empty($documentInternal) && $documentInternal->getDocumenttypeid() != $document->getDocumenttypeid()) {
            $success = $documentFieldValueModel->deleteByDocumentId($document->getId());
        } else {
            $success = true;
        }

        //update document
        if($success) {
            $query = "UPDATE document SET title = :title, documenttypeid = :documenttypeid WHERE id = :id AND agentid = :agentid";
            $parameters = [
                ':title' => $document->getTitle(),
                ':documenttypeid' => $document->getDocumenttypeid(),
                ':id' => $document->getId(),
                ':agentid' => $this->getAgentId()
            ];

            $success = $this->executeQuery($query, $parameters);
        }

        //update document files
        if ($success) {
            $documentFileModel = new DocumentFileModel($this->getAgentId());
            $documentFileModel->setPDO($this->getPDO());

            foreach ($documentFiles as $documentFile) {
                if(!empty($documentFile->getPathToFile())) {
                    $documentFile->setDocumentId($document->getId());
                    $success &= $documentFileModel->update($documentFile);
                    if (!$success) {
                        break;
                    }
                }
            }
        }

        // update or insert document field values
        if ($success) {
            foreach ($documentFieldValues as $documentFieldValue) {
                $documentFieldValue->setDocumentId($document->getId());

                if (empty($documentFieldValue->getId())) {
                    $newId = $documentFieldValueModel->add($documentFieldValue);
                    $success &= !empty($newId);
                } else {
                    $success &= $documentFieldValueModel->update($documentFieldValue);
                }

                if (!$success) {
                    break;
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

    /**
     * @param $id int
     * @return bool
     */
    public function delete($id)
    {
        $query = "DELETE FROM document WHERE id = :id and agentid = :agentid";

        $parameters = [
            ':id' => $id,
            ':agentid' => $this->getAgentId()
        ];

        return $this->executeQuery($query, $parameters);
    }

}