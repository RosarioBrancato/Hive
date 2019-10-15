<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 09.10.2017
 * Time: 08:39
 */

namespace Controller;

use View\Layout\LayoutRendering;
use View\View;

class ErrorController
{
    public static function show404()
    {
        $view = new View("404.php");
        LayoutRendering::ShowView($view);
    }
}