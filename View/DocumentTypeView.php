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
    $editTypeTitle = "New";
    $action = $GLOBALS["ROOT_URL"] . '/settings/documenttypes/save';
    $inputTagAddition = "required";
} else if ($editType == EditType::Edit) {
    $editTypeTitle = "Edit";
    $action = $GLOBALS["ROOT_URL"] . '/settings/documenttypes/save';
    $inputTagAddition = "required";
} else if ($editType == EditType::Delete) {
    $editTypeTitle = "Delete";
    $action = $GLOBALS["ROOT_URL"] . '/settings/documenttypes/delete';
    $inputTagAddition = "readonly";
}

$cancelLink = $GLOBALS["ROOT_URL"] . '/settings/documenttypes';

?>
<div class="container">
    <?php SettingsMenu::GetMenu(); ?>

    <h1>Document Types</h1>

    <?php if ($editType == EditType::Add || $editType == EditType::Edit || $editType == EditType::Delete) { ?>
        <h2><?php echo $editTypeTitle; ?></h2>
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

    <?php } else if ($editType == EditType::View) { ?>
        <a href="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes/new' ?>" class="btn btn-info">New</a>
    <?php } ?>

    <h2>List</h2>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($documentTypes as $documentType) {
            echo "<tr>";
            echo '<td scope="row">' . $documentType->getNumber() . '</td>';
            echo '<td>' . $documentType->getName() . '</td>';
            echo '<td><a href="' . $GLOBALS["ROOT_URL"] . '/settings/documenttypes/edit?id=' . $documentType->getId() . '">Edit</a> <a href="' . $GLOBALS["ROOT_URL"] . '/settings/documenttypes/delete?id=' . $documentType->getId() . '">Delete</a></td>';
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
