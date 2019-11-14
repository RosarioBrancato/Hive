<?php

namespace View\Layout;

class SettingsMenu
{

    public static function GetMenu()
    {
        ?>
        <div class="well">
            <a href="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes' ?>" class="btn btn-default">Document
                Types</a>
            <a href="#" class="btn btn-default">Document Fields</a>
        </div>
        <?php
    }

}