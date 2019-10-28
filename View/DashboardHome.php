<?php
    $name = $_SESSION["agentLogin"]["agent"]->getName();
 ?>
<div class="container">
    <h1>Dashboard Home</h1>
    <p>Welcome <?php echo $name; ?></p>
</div>