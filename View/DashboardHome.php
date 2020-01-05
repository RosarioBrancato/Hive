<?php

use View\View;

$name = View::NoHTML($this->agent->getName());

?>
<div class="container">
    <h1>Dashboard Home</h1>
    <p>Welcome <?php echo $name; ?></p>
    <a href="<?php echo $GLOBALS["ROOT_URL"] . '/documents/new'; ?>" class="btn btn-info">Add Document</a>
</div>