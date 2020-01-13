<?php


namespace Access;


use Controller\DashboardController;
use DTO\DocumentField;

class DashboardAccess
{

    public static function Statistics()
    {
        $controller = new DashboardController();
        $controller->GetDocumentTypeStatistics();
    }

    public static function CustomStatistics()
    {
        if (isset($_GET["label"], $_GET["fieldtype"])) {

            $documentField = new DocumentField();
            $documentField->setLabel($_GET["label"]);
            $documentField->setFieldType($_GET["fieldtype"]);

            $controller = new DashboardController();
            $controller->GetCustomStatistics($documentField);
        }
    }


}