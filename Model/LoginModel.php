<?php


namespace Model;


use Database\DbAccess;
use PDO;

class LoginModel extends _Model
{

    public function GetUserId($username, $password)
    {
        /*
        $id = -1;

        $query = 'select id from public.user where name = :username and password = :password';

        $stmt = $this->getPDO()->prepare($query);
        $stmt->execute(array('username' => $username, 'password' => $password));

        if ($stmt) {
            ///while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //    echo '<p>ID: ' . $row['id'] . '</p>';
            //}

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($row['id'])) {
                $id = $row['id'];
            }
        }

        return $id;
        */
    }

}