<?php


namespace DTO;


class DocumentFieldValue
{

    private $id;
    private $documentid;
    private $number;
    private $label;
    private $fieldtype;
    private $stringvalue;
    private $intvalue;
    private $decimalvalue;
    private $boolvalue;
    private $datevalue;

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
    public function getDocumentId()
    {
        return $this->documentid;
    }

    /**
     * @param mixed $documentid
     */
    public function setDocumentId($documentid)
    {
        $this->documentid = $documentid;
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
    public function getStringValue()
    {
        return $this->stringvalue;
    }

    /**
     * @param mixed $stringvalue
     */
    public function setStringValue($stringvalue)
    {
        $this->stringvalue = $stringvalue;
    }

    /**
     * @return mixed
     */
    public function getIntValue()
    {
        return $this->intvalue;
    }

    /**
     * @param mixed $intvalue
     */
    public function setIntValue($intvalue)
    {
        $this->intvalue = $intvalue;
    }

    /**
     * @return mixed
     */
    public function getDecimalValue()
    {
        return $this->decimalvalue;
    }

    /**
     * @param mixed $decimalvalue
     */
    public function setDecimalValue($decimalvalue)
    {
        $this->decimalvalue = $decimalvalue;
    }

    /**
     * @return mixed
     */
    public function getBoolValue()
    {
        return $this->boolvalue;
    }

    /**
     * @param mixed $boolvalue
     */
    public function setBoolValue($boolvalue)
    {
        $this->boolvalue = $boolvalue;
    }

    /**
     * @return mixed
     */
    public function getDatevalue()
    {
        return $this->datevalue;
    }

    /**
     * @param mixed $datevalue
     */
    public function setDateValue($datevalue)
    {
        $this->datevalue = $datevalue;
    }

}