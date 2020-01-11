<?php
/**
 * Created by PhpStorm.
 * User: leeko
 * Date: 08/01/2020
 * Time: 23:59
 */

namespace Model;


class ProfileModel extends _Model
{

    public function get()
    {
        $query = "SELECT name, email FROM agent WHERE id = :id";

        $parameters = [
            ':id' => $this->getAgentId()
        ];

        $result = $this->executeQuerySelect($query, $parameters);
        if (!empty($result) && sizeof($result)) {
            return $result[0];
        }
    }


}