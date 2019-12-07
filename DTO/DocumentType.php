<?php


namespace DTO;


class DocumentType
{
    private $id;
    private $number;
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

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
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

    public function setAgentId($agentId)
    {
        $this->agentid = $agentId;
    }

}