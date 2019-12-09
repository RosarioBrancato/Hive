<?php


namespace View\Layout;

use View\View;


class LayoutRendering
{

    public static function ShowView(View $contentView, View $submenu = null)
    {
        $view = new View("Layout/Layout.php");
        $view->header = (new View("Layout/Header.php"))->Render();

        if (!empty($submenu)) {
            $view->submenu = $submenu->Render();
        }

        $view->reportSection = (new View("Layout/ReportSection.php"))->Render();
        $view->content = $contentView->Render();

        /*
        $view->content = "";
        for ($i = 0; $i < sizeof($contentView); $i++) {
            $view->content .= $contentView[$i]->Render();
        }
        */

        $view->footer = (new View("Layout/Footer.php"))->Render();
        echo $view->Render();
    }

}