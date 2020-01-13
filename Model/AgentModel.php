<?php


namespace Model;


use DTO\Agent;
use DTO\DocumentField;
use DTO\DocumentType;
use Enumeration\FieldType;

class AgentModel extends _Model
{
    /**
     * @access public
     * @param Agent $agent
     * @return Agent
     * @ParamType agent Agent
     * @ReturnType Agent
     */
    public function create(Agent $agent)
    {
        $this->getPDO()->beginTransaction();

        $stmt = $this->getPDO()->prepare('
        INSERT INTO agent (name, email, password, timezone) SELECT :name, :email, :password, :timezone
          WHERE NOT EXISTS (
            SELECT email FROM agent WHERE email = :emailExist
        )');
        $stmt->bindValue(':name', $agent->getName());
        $stmt->bindValue(':email', $agent->getEmail());
        $stmt->bindValue(':emailExist', $agent->getEmail());
        $stmt->bindValue(':password', $agent->getPassword());
        $stmt->bindValue(':timezone', $agent->getTimezone());
        $success = $stmt->execute();

        $newAgentId = $this->getPDO()->lastInsertId();

        if ($success) {
            $documentTypeModel = new DocumentTypeModel($newAgentId);
            $documentTypeModel->setPDO($this->getPDO());
            $documentFieldModel = new DocumentFieldModel($newAgentId);
            $documentFieldModel->setPDO($this->getPDO());

            // general
            $general = new DocumentType();
            $general->setNumber(1);
            $general->setName("general");
            $general->setAgentId($newAgentId);

            // invoice
            $invoice = new DocumentType();
            $invoice->setNumber(2);
            $invoice->setName("invoice");
            $invoice->setAgentId($newAgentId);

            $invoiceAmount = new DocumentField();
            $invoiceAmount->setNumber(1);
            $invoiceAmount->setLabel("Amount");
            $invoiceAmount->setFieldType(FieldType::DecimalField);

            // insert data
            $success = $documentTypeModel->add($general);
            if ($success) {
                $success = $documentTypeModel->add($invoice);
            }

            if ($success) {
                $invoiceAmount->setDocumentTypeId($invoice->getId());
                $documentFieldModel->add($invoiceAmount);
            }
        }

        if ($success) {
            $this->getPDO()->commit();
        } else {
            $this->getPDO()->rollBack();
        }

        return $this->read($newAgentId);
    }

    /**
     * @access public
     * @param int agentId
     * @return Agent
     * @ParamType agentId int
     * @ReturnType Agent
     */
    public function read($agentId)
    {
        $stmt = $this->getPDO()->prepare('SELECT * FROM agent WHERE id = :id');
        $stmt->bindValue(':id', $agentId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "DTO\Agent")[0];
        }

        return null;
    }

    /**
     * @access public
     * @param Agent agent
     * @return Agent
     * @ParamType agent Agent
     * @ReturnType Agent
     */
    public function update(Agent $agent)
    {
        $stmt = $this->getPDO()->prepare('UPDATE agent SET name=:name, email=:email, password=:password, timezone=:timezone WHERE id = :id');
        $stmt->bindValue(':id', $agent->getId());
        $stmt->bindValue(':name', $agent->getName());
        $stmt->bindValue(':email', $agent->getEmail());
        $stmt->bindValue(':password', $agent->getPassword());
        $stmt->bindValue(':timezone', $agent->getTimezone());
        $stmt->execute();

        return $this->read($agent->getId());
    }

    /**
     * @access public
     * @param String email
     * @return Agent
     * @ParamType email String
     * @ReturnType Agent
     */
    public function findByEmail($email)
    {
        $stmt = $this->getPDO()->prepare('SELECT * FROM agent WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "DTO\Agent")[0];
        }

        return null;
    }
}