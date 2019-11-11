<?php


namespace DTO;


class DocumentType
{
    private $id;
    private $name;
    private $agentid;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getAgentId()
    {
        return $this->agentid;
    }

    public function setAgentId($agentid)
    {
        $this->agentid = $agentid;
    }

}