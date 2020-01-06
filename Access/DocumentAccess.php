<?php


namespace Access;


use Controller\DocumentController;
use DTO\Document;
use DTO\DocumentFieldValue;
use DTO\DocumentFile;
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
        if (!isset($_POST["title"], $_POST["documentTypeId"], $_FILES["file"])) {
            if (!isset($_POST["title"])) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Invalid title."));
            }
            if (!isset($_POST["documenttypeid"])) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Invalid document type."));
            }
            if (!isset($_FILES["file"])) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Invalid file."));
            }
            Router::redirect("/documents");
        }

        $document = new Document();
        $document->setTitle($_POST['title']);
        $document->setDocumenttypeid(intval($_POST['documentTypeId']));

        $fieldValues = array();
        foreach (array_keys($_POST) as $key) {
            if ($key != "title" && $key != "documentTypeId") {
                $documentFieldValue = new DocumentFieldValue();
                $documentFieldValue->setLabel($key);
                $documentFieldValue->setStringValue($_POST[$key]);
                array_push($fieldValues, $documentFieldValue);
            }
        }

        $filecontents = array();
        foreach ($_FILES as $file) {
            if ($stream = fopen($file["tmp_name"], "r")) {
                $filecontent = new DocumentFile();
                $filecontent->setFilename($file["name"]);
                $filecontent->setFilecontent(stream_get_contents($stream));
                array_push($filecontents, $filecontent);
                fclose($stream);
            }
        }

        $controller = new DocumentController();
        $controller->InsertDocument($document, $filecontents, $fieldValues);
    }

}