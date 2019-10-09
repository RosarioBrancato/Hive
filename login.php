<?php

$username = $_POST["username"];
$password = $_POST["password"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h1>User Logged In</h1>
    <?php
    $config = simplexml_load_file('Config/Hive.config.xml');
    $host = $config->Database->Host;
    $db = $config->Database->Name;
    $db_user = $config->Database->UserName;
    $db_pw = $config->Database->Password;

    $dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$db_user;password=$db_pw";

    $conn = new PDO($dsn);
    if ($conn) {
        //echo "Connected to the <strong>$db</strong> database successfully!<br>";
    }

    //$query = 'select id, "name", password from public.user where name=:username';
    $query = 'select id, "name", password from public.user where name = :username and password = :password';
    $stmt = $conn->prepare($query);
    $stmt->execute(array(':username' => $username, 'password' => $password));

    if ($stmt) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<p>ID: ' . $row['id'] . '</p>';
        }
    }
    ?>
    <p>End of page.</p>
</div>

</body>
</html>
