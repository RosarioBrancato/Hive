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

//var_dump($this->document);
//var_dump($this->documentTypes);
//var_dump($this->documentFieldValues);

$action = $GLOBALS["ROOT_URL"] . '/documents/save';

?>
<div class="container">
    <h1>Add Document</h1>
    <div>
        <form method="post" action="<?php echo $action ?>">
            <div class="form-group">
                <label>File</label>
                <input type="file" name="file" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" min="1" value="<?php echo $this->document->getTitle(); ?>" required/>
            </div>
            <div class="form-group">
                <label>Document Type</label>
                <?php DropDownHelper::GetDocumentTypes($this->documentTypes, -1, "required"); ?>
            </div>
            <?php
            foreach ($this->documentFieldValues as $documentFieldValue) {
                DocumentFieldsGenerator::GenerateInputTags($documentFieldValue);
            }
            ?>
        </form>
    </div>
</div>
