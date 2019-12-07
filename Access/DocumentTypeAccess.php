<?php

namespace Access;

use Controller\DocumentTypeController;
use DTO\DocumentType;
use DTO\ReportEntry;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Router\Router;

class DocumentTypeAccess
{

    public static function Home()
    {
        $controller = new DocumentTypeController();
        $controller->ShowHomePage();
    }

    public static function New()
    {
        $documentType = new DocumentType();

        if (!empty($_GET["number"])) {
            $documentType->setNumber(intval($_GET["number"]));
        }
        if (!empty($_GET["name"])) {
            $documentType->setName($_GET["name"]);
        }

        $controller = new DocumentTypeController();
        $controller->ShowNewForm($documentType);
    }

    public static function Edit()
    {
        $controller = new DocumentTypeController();

        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);

            $documentType = new DocumentType();
            $documentType->setId($id);

            if (isset($_GET["number"])) {
                $documentType->setName(intval($_GET["number"]));
            }
            if (isset($_GET["name"])) {
                $documentType->setName($_GET["name"]);
            }

            $controller->ShowEditForm($documentType);

        } else {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document type could not be found."));
            Router::redirect("/settings/documenttypes");
        }
    }

    public static function Delete()
    {
        $controller = new DocumentTypeController();

        if (isset($_GET["id"])) {
            $id = intval($_GET["id"]);
            $controller->ShowDeleteForm($id);

        } else if (isset($_POST["id"])) {
            $id = intval($_POST["id"]);
            $controller->DeleteEntry($id);

        } else {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document type could not be found."));
            Router::redirect("/settings/documenttypes");
        }
    }

    public static function Save()
    {
        if (!isset($_POST["number"], $_POST["name"])) {
            if (!isset($_POST["number"])) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Invalid number."));
            }
            if (!isset($_POST["name"])) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Invalid name."));
            }
            Router::redirect("/settings/documenttypes");
        }

        $documentType = new DocumentType();
        $documentType->setNumber(intval($_POST["number"]));
        $documentType->setName($_POST["name"]);

        $controller = new DocumentTypeController();

        if (!empty($_POST["id"])) {
            $documentType->setId(intval($_POST["id"]));
            $success = $controller->UpdateEntry($documentType);
            if (!$success) {
                Router::redirect("/settings/documenttypes/edit?id=" . $_POST["id"] . "&number=" . $_POST["number"] . "&name=" . $_POST["name"]);
            }

        } else {
            $success = $controller->InsertEntry($documentType);
            if (!$success) {
                Router::redirect("/settings/documenttypes/new?name=" . $_POST["name"]);
            }
        }

        Router::redirect("/settings/documenttypes");
    }

}