<?php

namespace Enumeration;

abstract class FieldType
{
    const TextField = 0;
    const DateField = 1;
    const DecimalField = 2;
    const NumberField = 3;


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
            case FieldType::DecimalField:
                $text = "decimal field";
                break;
            case FieldType::NumberField:
                $text = "number field";
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
            <option value="<?php echo FieldType::DecimalField; ?>" <?php echo $selectedId == FieldType::DecimalField ? " selected " : ""; ?>><?php echo FieldType::GetText(FieldType::DecimalField); ?></option>
            <option value="<?php echo FieldType::NumberField; ?>" <?php echo $selectedId == FieldType::NumberField ? " selected " : ""; ?>><?php echo FieldType::GetText(FieldType::NumberField); ?></option>
        </select>
        <?php
    }
}