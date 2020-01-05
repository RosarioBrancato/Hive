<?php


namespace Model;


class DocumentModel extends _Model
{

    public function getAll()
    {
        $query = 'SELECT d.*, v.* FROM document d LEFT JOIN documentfieldvalue v ON v.documentid = d.id WHERE agentid = :agentId ORDER BY d.created desc, v.number';
        $parameters = [
            ':agentId' => $this->agentId
        ];

        return $this->executeQuerySelect($query, $parameters);
    }

}