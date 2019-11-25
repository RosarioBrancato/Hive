<?php


namespace Controller;


use DTO\ReportEntry;
use Enumeration\EditType;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Model\DocumentTypeModel;
use Router\Router;
use Service\AuthServiceImpl;
use View\Layout\LayoutRendering;
use View\View;
use DTO\DocumentType;

class DocumentTypeController
{

    public static function Home()
    {
        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();

        $model = new DocumentTypeModel($agentId);
        $types = $model->getAll();

        $view = new View('DocumentTypeView.php');
        $view->editType = EditType::View;
        $view->documentTypes = $types;
        LayoutRendering::ShowView($view);
    }

    public static function New()
    {
        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $model = new DocumentTypeModel($agentId);

        $documentTypes = $model->getAll();
        $nextNumber = $model->getNextFreeNumber();

        $view = new View('DocumentTypeView.php');
        $view->editType = EditType::Add;
        $view->documentTypes = $documentTypes;
        $view->nextNumber = $nextNumber;
        LayoutRendering::ShowView($view);
    }

    public static function Edit()
    {
        if (!isset($_GET["id"])) {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document type could not be found."));
            Router::redirect("/settings/documenttypes");
        }

        $id = $_GET["id"];
        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $model = new DocumentTypeModel($agentId);

        $documentTypes = $model->getAll();
        $documentType = $model->get($id);

        if ($documentType != null) {
            $view = new View('DocumentTypeView.php');
            $view->editType = EditType::Edit;
            $view->documentTypes = $documentTypes;
            $view->documentType = $documentType;
            LayoutRendering::ShowView($view);
        } else {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document type could not be found."));
            Router::redirect("/settings/documenttypes");
        }
    }

    public static function Delete()
    {
        if (!isset($_GET["id"]) && !isset($_POST["id"])) {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document type could not be found."));
            Router::redirect("/settings/documenttypes");
        }

        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $model = new DocumentTypeModel($agentId);

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $documentType = $model->get($id);
            $documentTypes = $model->getAll();

            if ($documentType != null) {
                $view = new View('DocumentTypeView.php');
                $view->editType = EditType::Delete;
                $view->documentTypes = $documentTypes;
                $view->documentType = $documentType;
                LayoutRendering::ShowView($view);
            } else {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document type could not be found."));
                Router::redirect("/settings/documenttypes");
            }

        } else {
            $id = $_POST["id"];
            $model->delete($id);
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, "Document type deleted."));
            Router::redirect("/settings/documenttypes");
        }
    }

    public static function Save()
    {
        if (!isset($_POST["number"]) || !isset($_POST["name"])) {
            if (!isset($_POST["number"])) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Invalid number."));
            }
            if (!isset($_POST["name"])) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Invalid name."));
            }
            Router::redirect("/settings/documenttypes");
        }

        if (!isset($_POST["id"])) {
            $success = self::insert();
            if (!$success) {
                Router::redirect("/settings/documenttypes/new");
            }

        } else {
            $success = self::update();
            if (!$success) {
                Router::redirect("/settings/documenttypes/edit?id=" . $_POST["id"]);
            }
        }

        Router::redirect("/settings/documenttypes");
    }

    private static function insert()
    {
        $success = false;

        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $model = new DocumentTypeModel($agentId);

        $number = intval($_POST["number"]);
        $name = $_POST["name"];

        $isUnique = $model->isNameUnique($name);
        if (!$isUnique) {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "A document type named '" . $name . "' already exists"));
        }

        if ($isUnique) {
            $documentType = new DocumentType();
            $documentType->setNumber($number);
            $documentType->setName($name);
            $documentType->setAgentId($agentId);

            $success = $model->add($documentType);
            if (!$success) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "Document type could not be saved."));
            }
        }

        if ($success) {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, "Document type saved."));
        }

        return $success;
    }

    public static function update()
    {
        $success = false;

        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $model = new DocumentTypeModel($agentId);

        $id = intval($_POST["id"]);
        $number = intval($_POST["number"]);
        $name = $_POST["name"];

        $isUnique = $model->isNameUnique($name, $id);
        if (!$isUnique) {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "A document type named '" . $name . "' already exists"));
        }

        if ($isUnique) {
            $documentType = $model->get($id);
            if ($documentType == null) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "Document type could not be found."));

            } else {
                $documentType->setNumber($number);
                $documentType->setName($name);

                $success = $model->edit($documentType);
                if (!$success) {
                    ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "Document type could not be saved."));
                }
            }
        }

        if ($success) {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, "Document type saved."));
        }

        return $success;
    }

}