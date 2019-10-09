<?php
$text = 'Another text 2.';
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
    <h1>My First Bootstrap Page</h1>
    <p>This is some text.</p>
    <?php
    echo "<p>$text</p>";
    ?>
    <form method="post" action="login.php">
        <p>Username<input type="text" name="username" value="Rosario"/></p>
        <p>Password<input type="password" name="password" value="1234"/></p>
        <p><input type="submit" value="Login"/></p>
    </form>
</div>

</body>
</html>