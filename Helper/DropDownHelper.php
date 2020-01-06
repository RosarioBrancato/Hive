<?php


namespace Helper;


class DropDownHelper
{

    public static function GetDocumentTypes($documentTypes, $selectedId = -1, $tagAdditions = "")
    {
        if (empty($documentTypes)) {
            $documentTypes = array();
        }
        if (empty($selectedId)) {
            $selectedId = -1;
        }
        if (empty($tagAdditions)) {
            $tagAdditions = "";
        }
        ?>
        <select id="documentTypeId" name="documentTypeId" class="form-control" <?php echo $tagAdditions; ?>>
            <?php
            foreach ($documentTypes as $entry) {
                ?>
                <option value="<?php echo $entry->getId(); ?>" <?php echo $entry->getId() == $selectedId ? "selected" : ""; ?> ><?php echo $entry->getName(); ?></option>
                <?php
            }
            ?>
        </select>
        <?php
    }
}
