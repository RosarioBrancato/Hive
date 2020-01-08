<?php


namespace Model;


class DocumentFieldValueModel extends _Model
{

    public function getByDocumentId(int $documentId)
    {
        $query = "SELECT dfv.* 
                    FROM documentfieldvalue dfv 
                    LEFT JOIN document d ON d.id = dfv.documentid
                    WHERE dfv.documentid = :documentid AND d.agentid = :agentid
                    ORDER BY dfv.number";


        $parameter = [
            ':documentid' => $documentId,
            ':agentid' => $this->getAgentId()
        ];

        return $this->executeQuerySelect($query, $parameter, "DTO\DocumentFieldValue");
    }

}