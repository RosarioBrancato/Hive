<?php


namespace Model;


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

}