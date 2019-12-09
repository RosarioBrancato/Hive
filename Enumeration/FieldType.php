<?php

namespace Enumeration;

abstract class FieldType
{
    const TextField = 0;
    const DateField = 1;


    public static function GetText($fieldType)
    {
        $text = "";

        switch ($fieldType) {
            case FieldType::TextField:
                $text = "text field";
                break;
            case FieldType::DateField:
                $text = "date field";
                break;
        }

        return $text;
    }

    public static function GetAsDropDown($selectedId = -1, $tagAdditions = "")
    {
        if (empty($selectedId)) {
            $selectedId = -1;
        }
        if (empty($tagAdditions)) {
            $tagAdditions = "";
        }
        ?>
        <select name="fieldType" class="form-control" <?php echo $tagAdditions; ?>>
            <option value="<?php echo FieldType::TextField; ?>" <?php echo $selectedId == FieldType::TextField ? " selected " : ""; ?>><?php echo FieldType::GetText(FieldType::TextField); ?></option>
            <option value="<?php echo FieldType::DateField; ?>" <?php echo $selectedId == FieldType::DateField ? " selected " : ""; ?>><?php echo FieldType::GetText(FieldType::DateField); ?></option>
        </select>
        <?php
    }
}