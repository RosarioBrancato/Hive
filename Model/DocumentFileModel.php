<?php


namespace Model;


use DTO\DocumentFile;

class DocumentFileModel extends _Model
{

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id)
    {
        $query = 'SELECT df.* 
                    FROM documentfile df
                    LEFT JOIN document d ON d.id = df.documentid
                    WHERE df.id = :id AND d.agentid = :agentid';

        $parameters = [
            ':id' => $id,
            ':agentid' => $this->getAgentId()
        ];

        $array = $this->executeQuerySelect($query, $parameters, 'DTO\DocumentFile');
        if (isset($array) && sizeof($array) > 0) {
            return $array[0];
        }
    }

    /**
     * @param int $documentId
     * @return mixed
     */
    public function getByDocumentId(int $documentId)
    {
        $query = 'SELECT df.* 
                    FROM documentfile df
                    JOIN document d ON d.id = df.documentid
                    WHERE df.documentid = :documentid AND d.agentid = :agentid';

        $parameters = [
            ':documentid' => $documentId,
            ':agentid' => $this->getAgentId()
        ];

        $array = $this->executeQuerySelect($query, $parameters, 'DTO\DocumentFile');
        if (isset($array) && sizeof($array) > 0) {
            return $array[0];
        }
    }

    /**
     * @param $documentFile DocumentFile
     * @param $pathToFile string
     * @return string
     */
    public function add($documentFile)
    {
        $documentId = $documentFile->getDocumentid();
        $filename = $documentFile->getFilename();

        $pdo = $this->getPDO();

        $query = "INSERT INTO documentfile (documentid, filename, filecontent) VALUES (:documentid, :filename, :filecontent)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':documentid', $documentId);
        $stmt->bindParam(':filename', $filename);

        $stream = fopen($documentFile->getPathToFile(), "rb");
        $stmt->bindParam(':filecontent', $stream, \PDO::PARAM_LOB);

        $stmt->execute();
        $errorCode = $stmt->errorCode();
        if ($errorCode !== '00000') {
            error_log(implode(" | ", $stmt->errorInfo()));
        }

        return $pdo->lastInsertId();
    }

}