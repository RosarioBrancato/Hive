<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 12.09.2017
 * Time: 18:29
 */
echo $this->header;
if(!empty($this->submenu)) {
    echo $this->submenu;
}
echo $this->reportSection;
echo $this->content;
echo $this->footer;