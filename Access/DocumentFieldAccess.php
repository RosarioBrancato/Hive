<?php


namespace Access;


use Controller\DocumentFieldController;
use DTO\DocumentField;
use DTO\ReportEntry;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Router\Router;

class DocumentFieldAccess
{

    public static function Home()
    {
        $controller = new DocumentFieldController();
        $controller->ShowHomePage();
    }

    public static function New()
    {
        $documentField = new DocumentField();

        if (!empty($_GET["number"])) {
            $documentField->setNumber(intval($_GET["number"]));
        }
        if (!empty($_GET["label"])) {
            $documentField->setLabel($_GET["label"]);
        }
        if (!empty($_GET["fieldType"])) {
            $documentField->setFieldType(intval($_GET["fieldType"]));
        }
        if (!empty($_GET["documentTypeId"])) {
            $documentField->setDocumentTypeId(intval($_GET["documentTypeId"]));
        }

        $controller = new DocumentFieldController();
        $controller->ShowNewForm($documentField);
    }

    public static function Edit()
    {
        $controller = new DocumentFieldController();

        if (!empty($_GET["id"])) {
            $documentField = new DocumentField();
            $documentField->setId(intval($_GET["id"]));

            if (!empty($_GET["number"])) {
                $documentField->setNumber(intval($_GET["number"]));
            }
            if (!empty($_GET["label"])) {
                $documentField->setLabel($_GET["label"]);
            }
            if (!empty($_GET["fieldType"])) {
                $documentField->setLabel(intval($_GET["fieldType"]));
            }
            if (!empty($_GET["documentTypeId"])) {
                $documentField->setLabel(intval($_GET["documentTypeId"]));
            }

            $controller->ShowEditForm($documentField);

        } else {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document field could not be found."));
            Router::redirect("/settings/documentfields");
        }
    }

    public static function Delete()
    {
        $controller = new DocumentFieldController();

        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            $controller->ShowDeleteForm($id);

        } else if (!empty($_POST["id"])) {
            $id = intval($_POST["id"]);
            $controller->DeleteEntry($id);
            Router::redirect("/settings/documentfields");

        } else {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document field could not be found."));
            Router::redirect("/settings/documentfields");
        }
    }

    public static function Save()
    {
        if (!isset($_POST["number"], $_POST["label"], $_POST["fieldType"], $_POST["documentTypeId"])) {
            if (!isset($_POST["number"])) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Invalid number."));
            }
            if (!isset($_POST["label"])) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Invalid label."));
            }
            if (!isset($_POST["fieldType"])) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Invalid field type."));
            }
            if (!isset($_POST["documentTypeId"])) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Invalid document type."));
            }
            Router::redirect("/settings/documentfields");
        }

        $documentField = new DocumentField();
        $documentField->setNumber(intval($_POST["number"]));
        $documentField->setLabel($_POST["label"]);
        $documentField->setFieldType(intval($_POST["fieldType"]));
        $documentField->setDocumentTypeId(intval($_POST["documentTypeId"]));

        $controller = new DocumentFieldController();

        if (!empty($_POST["id"])) {
            $documentField->setId(intval($_POST["id"]));
            $success = $controller->UpdateEntry($documentField);
            if (!$success) {
                Router::redirect("/settings/documentfields/edit?id=" . $_POST["id"] . "&number=" . $_POST["number"] . "&label=" . $_POST["label"] . "&fieldtype=" . $_POST["fieldType"] . "&documenttypeid=" . $_POST["documentTypeId"]);
            }

        } else {
            $success = $controller->InsertEntry($documentField);
            if (!$success) {
                Router::redirect("/settings/documentfields/new?label=" . $_POST["label"] . "&fieldtype=" . $_POST["fieldType"] . "&documenttypeid=" . $_POST["documentTypeId"]);
            }
        }

        Router::redirect("/settings/documentfields");
    }

}