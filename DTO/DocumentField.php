<?php


namespace DTO;


class DocumentField
{
    private $id;
    private $number;
    private $label;
    private $fieldtype;
    private $documenttypeid;

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
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getFieldType()
    {
        return $this->fieldtype;
    }

    /**
     * @param mixed $fieldtype
     */
    public function setFieldType($fieldtype)
    {
        $this->fieldtype = $fieldtype;
    }

    /**
     * @return mixed
     */
    public function getDocumentTypeId()
    {
        return $this->documenttypeid;
    }

    /**
     * @param mixed $documenttypeid
     */
    public function setDocumentTypeId($documenttypeid)
    {
        $this->documenttypeid = $documenttypeid;
    }
}