<?php

namespace Util;

use DTO\DocumentFieldValue;
use Enumeration\FieldType;

class DocumentFieldsGenerator
{

    /**
     * @param $documentFieldValue DocumentFieldValue
     */
    public static function GenerateInputTags($documentFieldValue)
    {
        $dfv = $documentFieldValue;

        if ($dfv->getFieldType() == FieldType::TextField) {
            ?>
            <div class="form-group">
                <label><?php echo $dfv->getLabel(); ?></label>
                <input type="text" name="<?php echo $dfv->getLabel(); ?>" class="form-control" min="1" value="<?php echo $dfv->getStringValue(); ?>"/>
            </div>
            <?php
        } else if ($dfv->getFieldType() == FieldType::DateField) {
            ?>
            <div class="form-group">
                <label><?php echo $dfv->getLabel(); ?></label>
                <input type="datetime-local" name="<?php echo $dfv->getLabel(); ?>" class="form-control" min="1" value="<?php echo $dfv->getDatevalue(); ?>"/>
            </div>
            <?php
        }
    }

}