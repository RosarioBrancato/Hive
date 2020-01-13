<?php


namespace Model;


use DTO\DocumentField;
use DTO\DocumentFieldValue;
use Enumeration\FieldType;

class DashboardModel extends _Model
{

    public function getDocumentTypeStatistics()
    {
        $query = "SELECT dt.name as x, COUNT(d.id) as value 
                    FROM document d
                    JOIN documenttype dt ON dt.id = d.documenttypeid
                    WHERE d.agentid = :agentid
                    GROUP BY dt.name
                    ORDER BY dt.name";

        $parameters = [
            ':agentid' => $this->getAgentId()
        ];

        return $this->executeQuerySelect($query, $parameters);
    }

    /**
     * @param $groupBy DocumentField
     * @return array
     */
    public function getCustomStatistics($groupBy)
    {
        $query = "";

        if ($groupBy->getFieldType() == FieldType::NumberField) {
            $query = "SELECT dt.name as x, SUM(dfv.intvalue) as value 
                    FROM document d
                    JOIN documenttype dt ON dt.id = d.documenttypeid
                    JOIN documentfieldvalue dfv ON dfv.documentid = d.id
                    WHERE d.agentid = :agentid
                        AND dfv.label LIKE :label
                        AND dfv.fieldtype = :fieldtype
                    GROUP BY dt.name
                    ORDER BY dt.name";

        } else if($groupBy->getFieldType() == FieldType::DecimalField) {
            $query = "SELECT dt.name as x, SUM(dfv.decimalvalue) as value 
                    FROM document d
                    JOIN documenttype dt ON dt.id = d.documenttypeid
                    JOIN documentfieldvalue dfv ON dfv.documentid = d.id
                    WHERE d.agentid = :agentid
                        AND dfv.label LIKE :label
                        AND dfv.fieldtype = :fieldtype
                    GROUP BY dt.name
                    ORDER BY dt.name";

        } else if ($groupBy->getFieldType() == FieldType::CheckBox) {

            $query = "SELECT CONCAT(dfv.label, ' ', boolvalue) as x, COUNT(d.id) as value 
                    FROM documentfieldvalue dfv
                    JOIN document d ON d.id = dfv.documentid
                    WHERE label LIKE :label
                        AND d.agentid = :agentid
                        AND dfv.fieldtype = :fieldtype
                    GROUP BY CONCAT(dfv.label, ' ', boolvalue)
                    ORDER BY CONCAT(dfv.label, ' ', boolvalue)";
        }

        if(!empty($query)) {
            $parameters = [
                ':agentid' => $this->getAgentId(),
                ':label' => $groupBy->getLabel(),
                ':fieldtype' => $groupBy->getFieldType()
            ];

            return $this->executeQuerySelect($query, $parameters);
        }
    }

}