<?php


namespace View\Layout;

use View\View;


class LayoutRendering
{

    public static function basicLayout(View $contentView){
        $view = new View("Layout/Layout.php");
        $view->header = (new View("Layout/Header.php"))->render();
        $view->content = $contentView->render();
        $view->footer = (new View("Layout/Footer.php"))->render();
        echo $view->render();
    }

}