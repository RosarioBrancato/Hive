<?php
//var_dump($this->data);

?>


    <div class="container-fluid">
        <h3 class="text-dark mb-4">My Documents</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">List of my Documents</p>
            </div>
            <div class="card-body">
                <div>
                    <p>
                        <a href="<?php echo $GLOBALS["ROOT_URL"] . '/documents/new' ?>" class="btn btn-info">Add Document</a>
                    </p>
                </div>

                <!--<table class="table table-striped table-hover">-->
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table table-striped table-hover" data-toggle="table" data-search="true">
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
                                echo '<td>' . date("d.m.Y H:i", strtotime($entry->created)) . '</td>';
                                echo '<td><a href="' . $GLOBALS["ROOT_URL"] . '/documents/details?id=' . $entry->id . '">Details</a> | <a href="' . $GLOBALS["ROOT_URL"] . '/documents/edit?id=' . $entry->id . '">Edit</a> | <a href="' . $GLOBALS["ROOT_URL"] . '/documents/delete?id=' . $entry->id . '">Delete</a></td>';
                                echo "</tr>";
                            }
                        }
                        ?>
                        </tbody></table>
                </div>
                <div>
                </div>
            </div>
        </div>
    </div>



