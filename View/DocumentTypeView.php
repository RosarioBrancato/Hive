<?php

use Enumeration\EditType;
use View\Layout\SettingsMenu;

$editType = $this->editType;
$documentTypes = $this->documentTypes;

if (isset($this->documentType)) {
    $documentType = $this->documentType;
}

if(isset($this->nextNumber)) {
    $nextNumber = $this->nextNumber;
}

?>
<div class="container">
    <?php SettingsMenu::GetMenu(); ?>

    <h1>Document Type</h1>

    <?php if ($editType == EditType::Add) { ?>
        <h2>New</h2>
        <form method="post" action="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes/save' ?>">
            <div class="form-group">
                <label>Number</label>
                <input type="text" name="number" class="form-control" min="1" value="<?php echo $nextNumber; ?>" required/>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required/>
            </div>
            <input type="submit" class="btn btn-success" value="Add"/>
            <a href="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes' ?>" class="btn btn-info">Cancel</a>
        </form>
    <?php } ?>

    <?php if ($editType == EditType::Edit) { ?>
        <h2>Edit</h2>
        <form method="post" action="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes/save' ?>">
            <input type="hidden" name="id" value="<?php echo $documentType->getId(); ?>"/>
            <div class="form-group">
                <label>Number</label>
                <input type="text" name="number" class="form-control" min="1" value="<?php echo $documentType->getNumber(); ?>" required/>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $documentType->getName(); ?>" class="form-control" required/>
            </div>
            <input type="submit" class="btn btn-success" value="Save"/>
            <a href="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes' ?>" class="btn btn-info">Cancel</a>
        </form>
    <?php } ?>

    <?php if ($editType == EditType::Delete) { ?>
        <h2>Delete</h2>
        <form method="post" action="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes/delete' ?>">
            <input type="hidden" name="id" value="<?php echo $documentType->getId(); ?>"/>
            <div class="form-group">
                <label>Number</label>
                <input type="text" name="number" class="form-control" value="<?php echo $documentType->getNumber(); ?>" readonly/>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $documentType->getName(); ?>" class="form-control" readonly/>
            </div>
            <input type="submit" class="btn btn-danger" value="Delete"/>
            <a href="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes' ?>" class="btn btn-info">Cancel</a>
        </form>
    <?php } ?>

    <?php if ($editType == EditType::View) { ?>
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
