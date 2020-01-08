<?php

namespace Util;

use DTO\DocumentFieldValue;
use Enumeration\FieldType;

class DocumentFieldsGenerator
{

    /**
     * @param $documentFieldValue DocumentFieldValue
     * @param string $tagAdditions
     */
    public static function GenerateInputTags($documentFieldValue, $tagAdditions = "")
    {
        $dfv = $documentFieldValue;

        if ($dfv->getFieldType() == FieldType::TextField) {
            ?>
            <div class="form-group">
                <label><?php echo $dfv->getLabel(); ?></label>
                <input type="text" name="<?php echo $dfv->getLabel(); ?>" class="form-control" min="1" value="<?php echo $dfv->getStringValue(); ?>" <?php echo $tagAdditions; ?> />
            </div>
            <?php

        } else if ($dfv->getFieldType() == FieldType::DateField) {
            ?>
            <div class="form-group">
                <label><?php echo $dfv->getLabel(); ?></label>
                <input type="datetime-local" name="<?php echo $dfv->getLabel(); ?>" class="form-control" min="1" value="<?php echo $dfv->getDatevalue(); ?>" <?php echo $tagAdditions; ?> />
            </div>
            <?php

        } else if ($dfv->getFieldType() == FieldType::NumberField) {
            ?>
            <div class="form-group">
                <label><?php echo $dfv->getLabel(); ?></label>
                <input type="number" name="<?php echo $dfv->getLabel(); ?>" class="form-control" step="1" value="<?php echo $dfv->getIntValue(); ?>" <?php echo $tagAdditions; ?> />
            </div>
            <?php

        } else if ($dfv->getFieldType() == FieldType::DecimalField) {
            ?>
            <div class="form-group">
                <label><?php echo $dfv->getLabel(); ?></label>
                <input type="number" name="<?php echo $dfv->getLabel(); ?>" class="form-control" step="any" value="<?php echo $dfv->getDecimalValue(); ?>" <?php echo $tagAdditions; ?> />
            </div>
            <?php

        } else if ($dfv->getFieldType() == FieldType::CheckBox) {
            ?>
            <div class="form-group form-check">
                <input type="checkbox" id="<?php echo $dfv->getLabel(); ?>" name="<?php echo $dfv->getLabel(); ?>" class="form-check-input" value="<?php echo $dfv->getBoolValue(); ?>" <?php echo $tagAdditions; ?> />
                <label class="form-check-label" for="<?php echo $dfv->getLabel(); ?>"><?php echo $dfv->getLabel(); ?></label>
            </div>
            <?php
        }
    }

}