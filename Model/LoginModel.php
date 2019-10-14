<?php


namespace Model;


use PDO;

class LoginModel extends _Model
{

    public function GetUserId($username, $password)
    {
        $id = -1;

        $config = simplexml_load_file('Config/Hive.config.xml');
        $host = $config->Database->Host;
        $port = $config->Database->Port;
        $db = $config->Database->Name;
        $db_user = $config->Database->UserName;
        $db_pw = $config->Database->Password;

        $dsn = "pgsql:host=$host;port=$port;dbname=$db;user=$db_user;password=$db_pw";

        $conn = new PDO($dsn);
        if ($conn) {
            //echo "Connected to the <strong>$db</strong> database successfully!<br>";
        }

        //$query = 'select id, "name", password from public.user where name=:username';
        $query = 'select id, "name", password from public.user where name = :username and password = :password';
        $stmt = $conn->prepare($query);
        $stmt->execute(array(':username' => $username, 'password' => $password));

        if ($stmt) {
            /*while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<p>ID: ' . $row['id'] . '</p>';
            }*/

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($row['id'])) {
                $id = $row['id'];
            }
        }

        return $id;
    }

}