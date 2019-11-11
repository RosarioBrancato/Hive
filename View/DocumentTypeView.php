<?php

$documenttypes = $this->documenttypes

?>
<div class="container">
    <h1>Document Type</h1>

    <!--<p><?php echo var_dump($documenttypes); ?></p>-->

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($documenttypes as $documenttype) {
            echo "<tr>";
            echo '<td scope="row">' . $documenttype->getName() . '</td>';
            echo '<td><a href="#">Edit</a> <a href="#">Delete</a></td>';
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
