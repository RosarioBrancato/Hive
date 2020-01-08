<?php


namespace Access;


use Controller\DocumentController;
use DTO\Document;
use DTO\DocumentFieldValue;
use DTO\DocumentFile;
use DTO\ReportEntry;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Model\DocumentFileModel;
use Router\Router;
use Service\AuthServiceImpl;
use Util\FileUtils;

class DocumentAccess
{

    public static function Home()
    {
        $controller = new DocumentController();
        $controller->ShowHomePage();
    }

    public static function Details()
    {
        if (!isset($_GET["id"])) {
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, "ID not found.");
            Router::redirect("/documents");
        }

        $id = intval($_GET["id"]);
        $controller = new DocumentController();
        $controller->ShowDetails($id);
    }

    public static function File()
    {
        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);

            $model = new DocumentFileModel(AuthServiceImpl::getInstance()->getCurrentAgentId());
            $documentFile = $model->get($id);

            $mime = FileUtils::GetMimeFromFilename($documentFile->getFilename());

            if (!empty($mime)) {
                //$filename = $documentFile->getFilename();
                //header('Content-type:application/pdf; charset=utf-8');
                //header('Content-type:application/pdf');
                //header('Content-type: image/png');
                header('Content-type: ' . $mime);
                //header('Content-disposition: inline; filename="' . $filename . '"');
                //header('content-Transfer-Encoding:binary');
                //header('Accept-Ranges:bytes');

                print stream_get_contents($documentFile->getFilecontent());
                exit;
            }
        }
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

        $filecontents = array();
        foreach ($_FILES as $file) {
            $filecontent = new DocumentFile();
            $filecontent->setFilename($file["name"]);
            $filecontent->setPathToFile($file["tmp_name"]);
            array_push($filecontents, $filecontent);
        }

        $fieldValues = array();
        foreach (array_keys($_POST) as $key) {
            if ($key != "title" && $key != "documentTypeId") {
                $documentFieldValue = new DocumentFieldValue();
                $documentFieldValue->setLabel($key);
                $documentFieldValue->setStringValue($_POST[$key]);
                array_push($fieldValues, $documentFieldValue);
            }
        }

        $controller = new DocumentController();
        $controller->InsertDocument($document, $filecontents, $fieldValues);
    }

}