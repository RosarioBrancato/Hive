<?php

use DTO\Document;
use DTO\DocumentFile;
use Enumeration\EditType;
use Helper\DropDownHelper;
use Util\DocumentFieldsGenerator;

if (empty($this->editType)) {
    $this->editType = EditType::View;
}
if (empty($this->document)) {
    $this->document = new Document();
}
if (empty($this->documentTypes)) {
    $this->documentTypes = array();
}
if (empty($this->documentFile)) {
    $this->documentFile = new DocumentFile();
}
if (empty($this->documentFieldValues)) {
    $this->documentFieldValues = array();
}

$pagetitle = "Document Details";
$action = "";
$textSubmit = "";
$textCancel = "Back";
$tagAdditions = "";

if ($this->editType == EditType::View) {
    $tagAdditions = "disabled";

} else if ($this->editType == EditType::Add) {
    $pagetitle = "Add Document";
    $action = $GLOBALS["ROOT_URL"] . '/documents/save';
    $textSubmit = "Add";
    $textCancel = "Cancel";

} else if ($this->editType == EditType::Edit) {
    $pagetitle = "Edit Document";
    $action = $GLOBALS["ROOT_URL"] . '/documents/save';
    $textSubmit = "Save";
    $textCancel = "Cancel";

} else if ($this->editType == EditType::Delete) {
    $pagetitle = "Delete Document";
    $action = $GLOBALS["ROOT_URL"] . '/documents/delete';
    $textSubmit = "Delete";
    $textCancel = "Cancel";
    $tagAdditions = "disabled";
}

$cancelLink = $GLOBALS["ROOT_URL"] . '/documents';

?>
<div class="container-fluid">
    <h3 class="text-dark mb-4"><?php echo $pagetitle; ?></h3>


    <?php if (!empty($this->documentFile->getId())) { ?>
        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">View</p>
            </div>
            <div class="card-body">
                <embed src="<?php echo $GLOBALS["ROOT_URL"] . '/documents/file?id=' . $this->documentFile->getId(); ?>" width="100%" height="500px"/>
            </div>
        </div>
    <?php } ?>


    <div class="card shadow mb-3">
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">Details</p>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo $action ?>" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $this->document->getId(); ?>"/>

                <?php if ($this->editType == EditType::Add || $this->editType == EditType::Edit) { ?>
                    <div class="form-group">
                        <label>File</label>
                        <input type="file" id="file" name="file" class="form-control" accept="application/pdf, image/*, text/plain" <?php echo $this->editType == EditType::Add ? "required" : ""; ?> <?php echo $tagAdditions; ?> />
                    </div>
                <?php } ?>

                <div class="form-group">
                    <label>Title</label>
                    <input type="text" id="title" name="title" class="form-control" min="1" value="<?php echo $this->document->getTitle(); ?>" required <?php echo $tagAdditions; ?> />
                </div>

                <?php if ($this->editType == EditType::View || $this->editType == EditType::Edit || $this->editType == EditType::Delete) { ?>
                    <div class="form-group">
                        <label>Created</label>
                        <input type="datetime-local" class="form-control" value="<?php echo date("d.m.Y H:i", strtotime($this->document->getCreated())); ?>" disabled/>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <label>Document Type</label>
                    <?php DropDownHelper::GetDocumentTypes($this->documentTypes, $this->document->getDocumenttypeid(), ("required " . $tagAdditions)); ?>
                </div>

                <div id="generated-fields">
                    <?php
                    foreach ($this->documentFieldValues as $documentFieldValue) {
                        DocumentFieldsGenerator::GenerateInputTags($documentFieldValue, $tagAdditions);
                    }
                    ?>
                </div>

                <?php if ($this->editType == EditType::Add || $this->editType == EditType::Edit || $this->editType == EditType::Delete) { ?>
                    <input type="submit" class="btn btn-success" id="submit" value="<?php echo $textSubmit; ?>"/>
                <?php } ?>

                <a href="<?php echo $cancelLink; ?>" class="btn btn-info"><?php echo $textCancel; ?></a>
            </form>
        </div>
    </div>

    <?php if ($this->editType == EditType::Add || $this->editType == EditType::Edit) { ?>
        <script>
            $(document).ready(function () {

                $('#file').change(function () {
                    // set filename as title after file selection
                    var filepath = this.value;
                    filepath = filepath.replace(/\\/g, '/').split('.').shift();
                    var filename = filepath.substring(filepath.lastIndexOf('/')).replace('/', '');

                    $('#title').val(filename);
                });

                $('#documentTypeId').change(function () {
                    // load document fields after document type selection
                    $('#submit').prop('disabled', true);
                    $('#generated-fields').html('<p>LOADING FIELDS...</p>');

                    let selectedValue = $('#documentTypeId').val();
                    let url = "<?php echo $GLOBALS["ROOT_URL"] . '/settings/documentfields/get?documenttypeid='; ?>" + selectedValue;

                    $.ajax({
                        url: url,
                        success: function (result) {
                            $('#generated-fields').html(result);
                            $('#submit').prop('disabled', false);
                        },
                        error: function (result, textStatus, errorThrown) {
                            $('#generated-fields').html('');
                            $('#submit').prop('disabled', false);
                            console.log(result);
                            console.log(textStatus);
                            console.log(errorThrown);
                        }
                    });
                });
            });
        </script>
    <?php } ?>
