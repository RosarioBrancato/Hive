<?php

use DTO\Document;
use Helper\DropDownHelper;
use Util\DocumentFieldsGenerator;

if (empty($this->document)) {
    $this->document = new Document();
}
if (empty($this->documentTypes)) {
    $this->documentTypes = array();
}

$pagetitle = "My Documents";
if ($this->editType == \Enumeration\EditType::Add) {
    $pagetitle = "Add Document";
} else if ($this->editType == \Enumeration\EditType::Edit) {
    $pagetitle = "Edit Document";
} else if ($this->editType == \Enumeration\EditType::Delete) {
    $pagetitle = "Delete Document";
}

$action = $GLOBALS["ROOT_URL"] . '/documents/save';
$cancelLink = $GLOBALS["ROOT_URL"] . '/documents';

?>
<div class="container">
    <h1><?php echo $pagetitle; ?></h1>
    <div>
        <form method="post" action="<?php echo $action ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label>File</label>
                <input type="file" id="file" name="file" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" id="title" name="title" class="form-control" min="1" value="<?php echo $this->document->getTitle(); ?>" required/>
            </div>
            <div class="form-group">
                <label>Document Type</label>
                <?php DropDownHelper::GetDocumentTypes($this->documentTypes, -1, "required"); ?>
            </div>
            <div id="generated-fields">
                <?php
                foreach ($this->documentFieldValues as $documentFieldValue) {
                    DocumentFieldsGenerator::GenerateInputTags($documentFieldValue);
                }
                ?>
            </div>
            <input type="submit" class="btn btn-success" id="submit" value="Add"/>
            <a href="<?php echo $cancelLink; ?>" class="btn btn-info">Cancel</a>
        </form>
    </div>
</div>
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
