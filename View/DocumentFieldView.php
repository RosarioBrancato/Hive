<?php

use DTO\DocumentField;
use DTO\DocumentType;
use Enumeration\EditType;
use Enumeration\FieldType;
use Helper\DropDownHelper;
use Model\DocumentFieldModel;
use View\Layout\SettingsMenu;

$editType = $this->editType;
$data = $this->data;

if (!empty($this->documentField)) {
    /** @var DocumentField */
    $documentField = $this->documentField;
}

if (!empty($this->documentField)) {
    $documentTypes = $this->documentTypes;
}

if ($editType == EditType::Add) {
    $editTypeTitle = "New Document Field";
    $action = $GLOBALS["ROOT_URL"] . '/settings/documentfields/save';
    $inputTagAddition = "required";
    $selectTagAddition = "required";
} else if ($editType == EditType::Edit) {
    $editTypeTitle = "Edit Document Field";
    $action = $GLOBALS["ROOT_URL"] . '/settings/documentfields/save';
    $inputTagAddition = "required";
    $selectTagAddition = "required";
} else if ($editType == EditType::Delete) {
    $editTypeTitle = "Delete Document Field";
    $action = $GLOBALS["ROOT_URL"] . '/settings/documentfields/delete';
    $inputTagAddition = "readonly";
    $selectTagAddition = "disabled";
}

$cancelLink = $GLOBALS["ROOT_URL"] . '/settings/documentfields';

?>

<div class="container">
    <h2 class="text-dark mb-4">Document Fields</h2>

    <?php if ($editType == EditType::Add || $editType == EditType::Edit || $editType == EditType::Delete) { ?>
        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold"><?php echo $editTypeTitle; ?></p>
            </div>
            <div class="card-body">

                <form method="post" action="<?php echo $action ?>">
                    <input type="hidden" name="id" value="<?php echo $documentField->getId(); ?>"/>
                    <div class="form-group">
                        <label>Document Type</label>
                        <?php DropDownHelper::GetDocumentTypes($documentTypes, $documentField->getDocumentTypeId(), $selectTagAddition); ?>
                    </div>
                    <div class="form-group">
                        <label>Number</label>
                        <input type="text" name="number" class="form-control" min="1" value="<?php echo $documentField->getNumber(); ?>" <?php echo $inputTagAddition; ?>/>
                    </div>
                    <div class="form-group">
                        <label>Label</label>
                        <input type="text" name="label" class="form-control" value="<?php echo $documentField->getLabel(); ?>" <?php echo $inputTagAddition; ?>/>
                    </div>
                    <div class="form-group">
                        <label>Field Type</label>
                        <?php FieldType::GetAsDropDown($documentField->getFieldType(), $selectTagAddition); ?>
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
            <p class="text-primary m-0 font-weight-bold">List of Document Fields</p>
        </div>
        <div class="card-body">

            <?php if ($editType == EditType::View) { ?>
                <p><a href="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documentfields/new' ?>" class="btn btn-info">New</a></p>
            <?php } ?>

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Document Type</th>
                    <th scope="col">#</th>
                    <th scope="col">Label</th>
                    <th scope="col">Field Type</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($data as $entry) {
                    echo "<tr>";
                    echo '<td>' . $entry->documenttypenr . '</td>';
                    echo '<td>' . $entry->documenttype . '</td>';
                    echo '<td scope="row">' . $entry->number . '</td>';
                    echo '<td>' . $entry->label . '</td>';
                    echo '<td>' . FieldType::GetText($entry->fieldtype) . '</td>';
                    echo '<td><a href="' . $GLOBALS["ROOT_URL"] . '/settings/documentfields/edit?id=' . $entry->id . '">Edit</a> <a href="' . $GLOBALS["ROOT_URL"] . '/settings/documentfields/delete?id=' . $entry->id . '">Delete</a></td>';
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
