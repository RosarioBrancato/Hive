<?php

$documentTypes = $this->documentTypes

?>
<div class="container">
    <h1>Document Type</h1>

    <!--<p><?php echo var_dump($documentTypes); ?></p>-->

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($documentTypes as $documentType) {
            echo "<tr>";
            echo '<td scope="row">' . $documentType->getName() . '</td>';
            echo '<td><a href="#">Edit</a> <a href="#">Delete</a></td>';
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
