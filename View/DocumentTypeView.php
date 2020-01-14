<?php

use DTO\DocumentType;
use Enumeration\EditType;
use View\Layout\SettingsMenu;

$editType = $this->editType;
$documentTypes = $this->documentTypes;

if (isset($this->documentType)) {
    $documentType = $this->documentType;
} else {
    $documentType = new DocumentType();
}

if ($editType == EditType::Add) {
    $editTypeTitle = "New Document Type";
    $action = $GLOBALS["ROOT_URL"] . '/settings/documenttypes/save';
    $inputTagAddition = "required";
} else if ($editType == EditType::Edit) {
    $editTypeTitle = "Edit Document Type";
    $action = $GLOBALS["ROOT_URL"] . '/settings/documenttypes/save';
    $inputTagAddition = "required";
} else if ($editType == EditType::Delete) {
    $editTypeTitle = "Delete Document Type";
    $action = $GLOBALS["ROOT_URL"] . '/settings/documenttypes/delete';
    $inputTagAddition = "readonly";
}

$cancelLink = $GLOBALS["ROOT_URL"] . '/settings/documenttypes';

?>
<div class="container">
    <h2 class="text-dark mb-4">Document Types</h2>

    <?php if ($editType == EditType::Add || $editType == EditType::Edit || $editType == EditType::Delete) { ?>
        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold"><?php echo $editTypeTitle; ?></p>
            </div>
            <div class="card-body">

                <form method="post" action="<?php echo $action ?>">
                    <input type="hidden" name="id" value="<?php echo $documentType->getId(); ?>"/>
                    <div class="form-group">
                        <label>Number</label>
                        <input type="text" name="number" class="form-control" min="1" value="<?php echo $documentType->getNumber(); ?>" <?php echo $inputTagAddition; ?>/>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $documentType->getName(); ?>" <?php echo $inputTagAddition; ?>/>
                    </div>

                    <?php if ($editType == EditType::Add) { ?>
                        <input type="submit" class="btn btn-success" value="Add"/>
                    <?php } else if ($editType == EditType::Edit) { ?>
                        <input type="submit" class="btn btn-success" value="Update"/>
                    <?php } else if ($editType == EditType::Delete) { ?>
                        <input type="submit" class="btn btn-danger" value="Delete"/>
                    <?php } ?>

                    <a href="<?php echo $cancelLink; ?>" class="btn btn-info">Cancel</a>
                </form>

            </div>
        </div>
    <?php } ?>

    <div class="card shadow mb-3">
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">List of Document Types</p>
        </div>
        <div class="card-body">

            <?php if ($editType == EditType::View) { ?>
                <p><a href="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes/new' ?>" button class="btn btn-info">New</a></p>
            <?php } ?>

            <table id="table" class="table table-striped table-hover" data-mobile-responsive="true" data-check-on-init="true">
                <thead>
                <tr>
                    <th scope="col" class="text-right">#</th>
                    <th scope="col">Name</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($documentTypes as $documentType) {
                    echo "<tr>";
                    echo '<td scope="row" class="text-right">' . $documentType->getNumber() . '</td>';
                    echo '<td>' . $documentType->getName() . '</td>';
                    echo '<td><a href="' . $GLOBALS["ROOT_URL"] . '/settings/documenttypes/edit?id=' . $documentType->getId() . '">Edit</a> | <a href="' . $GLOBALS["ROOT_URL"] . '/settings/documenttypes/delete?id=' . $documentType->getId() . '">Delete</a></td>';
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>

        </div>
    </div>

</div>

<script>
    $(function () {
        $('#table').bootstrapTable()
    })
</script>