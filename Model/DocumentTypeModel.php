<?php


namespace Model;


class DocumentTypeModel extends _Model
{

    public function getAll($agentId)
    {
        $stmt = $this->getPDO()->prepare('SELECT * FROM documenttype WHERE agentid = :agentid');
        $stmt->bindValue(':agentid', $agentId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "DTO\DocumentType");
        }
    }


}