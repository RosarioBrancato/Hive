<?php
//var_dump($this->data);

?>
<div class="container">
    <h1>My Documents</h1>
    <p>
        <a href="<?php echo $GLOBALS["ROOT_URL"] . '/documents/new' ?>" class="btn btn-info">Add Document</a>
    </p>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Document Type</th>
            <th scope="col">Created</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($this->data)) {
            foreach ($this->data as $entry) {
                echo "<tr>";
                echo '<td scope="row">' . $entry->title . '</>';
                echo '<td>' . $entry->documenttypename . '</td>';
                echo '<td>' . $entry->created . '</td>';
                echo '<td><a href="' . $GLOBALS["ROOT_URL"] . '/documents/edit?id=' . $entry->id . '">Edit</a> <a href="' . $GLOBALS["ROOT_URL"] . '/documents/delete?id=' . $entry->id . '">Delete</a></td>';
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>
</div>
