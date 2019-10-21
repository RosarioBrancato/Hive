<?php


namespace Model;


use Database\DbAccess;
use DTO\AuthToken;

class AuthTokenModel extends _Model
{
    /**
     * @access public
     * @param AuthToken $authToken
     * @return AuthToken
     * @ParamType authToken AuthToken
     * @ReturnType AuthToken
     */
    public function create(AuthToken $authToken)
    {
        $stmt = $this->getPDO()->prepare('INSERT INTO authtoken (selector, validator, expiration, agentid, type) VALUES (:selector,:validator,:expiration, :agentid, :type);');
        $stmt->bindValue(':selector', $authToken->getSelector());
        $stmt->bindValue(':validator', $authToken->getValidator());
        $stmt->bindValue(':expiration', $authToken->getExpiration());
        $stmt->bindValue(':agentid', $authToken->getAgentid());
        $stmt->bindValue(':type', $authToken->getType());
        $stmt->execute();

        return $this->findBySelector($authToken->getSelector());
    }

    /**
     * @access public
     * @param AuthToken $authToken
     * @ParamType authToken AuthToken
     */
    public function delete(AuthToken $authToken)
    {
        $stmt = $this->getPDO()->prepare('DELETE FROM authtoken WHERE id = :id ');
        $stmt->bindValue(':id', $authToken->getId());
        $stmt->execute();
    }

    /**
     * @access public
     * @param String selector
     * @return AuthToken
     * @ParamType selector String
     * @ReturnType AuthToken
     */
    public function findBySelector($selector)
    {
        $stmt = $this->getPDO()->prepare('SELECT * FROM authtoken WHERE selector = :selector;');
        $stmt->bindValue(':selector', $selector);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "DTO\AuthToken")[0];
        }
        return null;
    }
}