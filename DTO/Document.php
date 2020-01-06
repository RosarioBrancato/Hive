<?php


namespace DTO;


class Document
{

    private $id;
    private $title;
    private $created;
    private $documenttypeid;
    private $agentid;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getDocumenttypeid()
    {
        return $this->documenttypeid;
    }

    /**
     * @param mixed $documenttypeid
     */
    public function setDocumenttypeid($documenttypeid)
    {
        $this->documenttypeid = $documenttypeid;
    }

    /**
     * @return mixed
     */
    public function getAgentid()
    {
        return $this->agentid;
    }

    /**
     * @param mixed $agentid
     */
    public function setAgentid($agentid)
    {
        $this->agentid = $agentid;
    }

}