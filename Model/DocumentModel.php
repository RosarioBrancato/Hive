<?php


namespace Model;


use DTO\Document;

class DocumentModel extends _Model
{

    public function getAll()
    {
        $query = 'SELECT d.*, dt.name as documenttypename 
                    FROM document d 
                    LEFT JOIN documenttype dt ON dt.id = d.documenttypeid 
                    WHERE d.agentid = :agentId 
                    ORDER BY d.number desc';

        $parameters = [
            ':agentId' => $this->getAgentId()
        ];

        return $this->executeQuerySelect($query, $parameters);
    }

}