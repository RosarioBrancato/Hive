<?php


namespace View\Layout;

use View\View;


class LayoutRendering
{

    public static function ShowView(View $contentView){
        $view = new View("Layout/Layout.php");
        $view->header = (new View("Layout/Header.php"))->Render();
        $view->content = $contentView->Render();
        $view->footer = (new View("Layout/Footer.php"))->Render();
        echo $view->Render();
    }

}