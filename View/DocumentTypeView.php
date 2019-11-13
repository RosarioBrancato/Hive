<?php

use Enumeration\EditType;

$editType = $this->editType;
$documentTypes = $this->documentTypes;

if (isset($this->documentType)) {
    $documentType = $this->documentType;
}

?>
<div class="container">
    <h1>Document Type</h1>

    <?php if ($editType == EditType::Add) { ?>
        <h2>New</h2>
        <form method="post" action="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes/save' ?>">
            <p>Name <input type="text" name="name" required /></p>
            <input type="submit" value="Add"/>
            <a href="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes' ?>">Cancel</a>
        </form>
    <?php } ?>

    <?php if ($editType == EditType::Edit) { ?>
        <h2>Edit</h2>
        <form method="post" action="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes/save' ?>">
            <input type="hidden" name="id" value="<?php echo $documentType->getId(); ?>"/>
            <p>Name <input type="text" name="name" value="<?php echo $documentType->getName(); ?>"/></p>
            <input type="submit" value="Save"/>
            <a href="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes' ?>">Cancel</a>
        </form>
    <?php } ?>

    <?php if ($editType == EditType::Delete) { ?>
        <h2>Delete</h2>
        <form method="post" action="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes/delete' ?>">
            <input type="hidden" name="id" value="<?php echo $documentType->getId(); ?>"/>
            <p>Name <input type="text" name="name" value="<?php echo $documentType->getName(); ?>" readonly /></p>
            <input type="submit" value="Delete"/>
            <a href="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes' ?>">Cancel</a>
        </form>
    <?php } ?>

    <?php if ($editType == EditType::View) { ?>
        <a href="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes/new' ?>">New</a>
    <?php } ?>

    <h2>List</h2>
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
            echo '<td><a href="' . $GLOBALS["ROOT_URL"] . '/settings/documenttypes/edit?id=' . $documentType->getId() . '">Edit</a> <a href="' . $GLOBALS["ROOT_URL"] . '/settings/documenttypes/delete?id=' . $documentType->getId() . '">Delete</a></td>';
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
