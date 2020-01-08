<?php


namespace DTO;


class DocumentFile
{

    private $id;
    private $documentid;
    private $filename;
    private $filecontent;
    private $pathToFile;

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
    public function getDocumentid()
    {
        return $this->documentid;
    }

    /**
     * @param mixed $documentid
     */
    public function setDocumentid($documentid)
    {
        $this->documentid = $documentid;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getFilecontent()
    {
        return $this->filecontent;
    }

    /**
     * @param mixed $filecontent
     */
    public function setFilecontent($filecontent)
    {
        $this->filecontent = $filecontent;
    }

    /**
     * @return mixed
     */
    public function getPathToFile()
    {
        return $this->pathToFile;
    }

    /**
     * @param mixed $pathToFile
     */
    public function setPathToFile($pathToFile)
    {
        $this->pathToFile = $pathToFile;
    }

}