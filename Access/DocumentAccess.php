<?php


namespace Access;


use Controller\DocumentController;
use DTO\Document;
use DTO\ReportEntry;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Router\Router;

class DocumentAccess
{

    public static function Home()
    {
        $controller = new DocumentController();
        $controller->ShowHomePage();
    }

    public static function New()
    {
        $document = new Document();

        $controller = new DocumentController();
        $controller->ShowNewForm($document);
    }

    public static function Edit()
    {

    }

    public static function Delete()
    {

    }

    public static function Save()
    {

        var_dump($_POST);
        var_dump($_FILES);

        /*
        if (!isset($_POST["number"], $_POST["label"], $_POST["fieldType"], $_POST["documentTypeId"])) {
            if (!isset($_POST["title"])) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Invalid title."));
            }
            if (!isset($_POST["documenttypeid"])) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Invalid document type."));
            }
            Router::redirect("/documents");
        }
        */


        /*
        $document = new Document();
        $document->setTitle($_POST['title']);
        $document->setDocumenttypeid(intval($_POST['documenttypeid']));
        */
    }

}