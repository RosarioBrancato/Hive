<?php


namespace Model;


use DTO\DocumentFieldValue;
use Util\DataTypeUtils;

class DocumentFieldValueModel extends _Model
{

    public function getByDocumentId(int $documentId)
    {
        $query = "SELECT dfv.* 
                    FROM documentfieldvalue dfv 
                    LEFT JOIN document d ON d.id = dfv.documentid
                    WHERE dfv.documentid = :documentid AND d.agentid = :agentid
                    ORDER BY dfv.number";


        $parameter = [
            ':documentid' => $documentId,
            ':agentid' => $this->getAgentId()
        ];

        return $this->executeQuerySelect($query, $parameter, "DTO\DocumentFieldValue");
    }

    /**
     * @param $documentFieldValue DocumentFieldValue
     * @return int
     */
    public function add($documentFieldValue)
    {
        $query = 'INSERT INTO documentfieldvalue (documentid, number, label, fieldtype, stringvalue, intvalue, decimalvalue, boolvalue, datevalue) 
                            VALUES (:documentid, :number, :label, :fieldtype, :stringvalue, :intvalue, :decimalvalue, :boolvalue, :datevalue)';
        $parameters = [
            ':documentid' => $documentFieldValue->getDocumentId(),
            ':number' => $documentFieldValue->getNumber(),
            ':label' => $documentFieldValue->getLabel(),
            ':fieldtype' => $documentFieldValue->getFieldType(),
            ':stringvalue' => $documentFieldValue->getStringValue(),
            ':intvalue' => $documentFieldValue->getIntValue(),
            ':decimalvalue' => $documentFieldValue->getDecimalValue(),
            ':boolvalue' => DataTypeUtils::ConvertToBit($documentFieldValue->getBoolValue()),
            ':datevalue' => DataTypeUtils::CheckDefaultValue($documentFieldValue->getDatevalue())
        ];

        return $this->executeQueryInsert($query, $parameters);
    }


    /**
     * @param $documentFieldValue DocumentFieldValue
     * @return bool
     */
    public function update($documentFieldValue)
    {
        $query = "UPDATE documentfieldvalue 
                    SET number = :number, 
                        label = :label, 
                        fieldtype = :fieldtype, 
                        stringvalue = :stringvalue, 
                        intvalue = :intvalue, 
                        decimalvalue = :decimalvalue, 
                        boolvalue = :boolvalue, 
                        datevalue = :datevalue
                    WHERE id = :id";

        $parameters = [
            ':number' => $documentFieldValue->getNumber(),
            ':label' => $documentFieldValue->getLabel(),
            ':fieldtype' => $documentFieldValue->getFieldType(),
            ':stringvalue' => $documentFieldValue->getStringValue(),
            ':intvalue' => $documentFieldValue->getIntValue(),
            ':decimalvalue' => $documentFieldValue->getDecimalValue(),
            ':boolvalue' => DataTypeUtils::ConvertToBit($documentFieldValue->getBoolValue()),
            ':datevalue' => DataTypeUtils::CheckDefaultValue($documentFieldValue->getDatevalue()),
            ':id' => $documentFieldValue->getId()
        ];

        return $this->executeQuery($query, $parameters);
    }

    public function deleteByDocumentId(int $documentId)
    {
        $query = "DELETE FROM documentfieldvalue dfv WHERE documentid = :documentid";

        $parameter = [
            ':documentid' => $documentId
        ];

        return $this->executeQuery($query, $parameter);
    }

}