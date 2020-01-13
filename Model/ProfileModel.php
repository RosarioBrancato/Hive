<?php
/**
 * Created by PhpStorm.
 * User: leeko
 * Date: 08/01/2020
 * Time: 23:59
 */

namespace Model;


use DTO\Agent;

class ProfileModel extends _Model
{

    public function get()
    {
        $query = "SELECT name, email, timezone FROM agent WHERE id = :id";

        $parameters = [
            ':id' => $this->getAgentId()
        ];

        $result = $this->executeQuerySelect($query, $parameters);
        if (!empty($result) && sizeof($result)) {
            return $result[0];
        }
    }

    public function update(Agent $agent)
    {
        $query = "UPDATE agent SET name = :name, email = :email, timezone = :timezone WHERE id = :id";

        $parameters = [
            ':name' => $agent->getName(),
            ':email' => $agent->getEmail(),
            ':timezone' => $agent->getTimezone(),
            ':id' => $this->getAgentId()
        ];

        return $this->executeQuery($query, $parameters);
    }

    public function delete()
    {
        $this->getPDO()->beginTransaction();

        $query = "DELETE FROM document WHERE agentid = :agentid";
        $parameters = [
            ":agentid" => $this->getAgentId()
        ];

        $isOk = $this->executeQuery($query, $parameters);

        if($isOk) {
            $query = "DELETE FROM documentfield WHERE documenttypeid IN (SELECT id FROM documenttype WHERE agentid = :agentid)";
            $isOk = $this->executeQuery($query, $parameters);
        }

        if($isOk) {
            $query = "DELETE FROM documenttype WHERE agentid = :agentid";
            $isOk = $this->executeQuery($query, $parameters);
        }

        if($isOk) {
            $query = "DELETE FROM authtoken WHERE agentid = :agentid";
            $isOk = $this->executeQuery($query, $parameters);
        }

        if($isOk) {
            $query = "DELETE FROM agent WHERE id = :agentid";
            $isOk = $this->executeQuery($query, $parameters);
        }

        if($isOk) {
            $this->getPDO()->commit();
        } else {
            $this->getPDO()->rollBack();
        }

        return $isOk;
    }


}