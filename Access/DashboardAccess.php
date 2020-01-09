<?php


namespace Access;


use Controller\DashboardController;

class DashboardAccess
{

    public static function Statistics()
    {
        $controller = new DashboardController();
        $controller->GetDocumentTypeStatistics();
    }


}