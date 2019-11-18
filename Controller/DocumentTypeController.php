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

        $view = new View('DocumentTypeView.php');
        $view->editType = EditType::Add;
        $view->documentTypes = $documentTypes;
        LayoutRendering::ShowView($view);
    }

    public static function Edit()
    {
        if (!isset($_GET["id"])) {
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
                Router::redirect("/settings/documenttypes");
            }

        } else {
            $id = $_POST["id"];
            $model->delete($id);
            Router::redirect("/settings/documenttypes");
        }
    }

    public static function Save()
    {
        if (!isset($_POST["name"])) {
            Router::redirect("/settings/documenttypes");
        }

        $name = $_POST["name"];
        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $model = new DocumentTypeModel($agentId);

        if (isset($_POST["id"])) {
            $id = intval($_POST["id"]);

            $documentType = $model->get($id);
            if ($documentType != null) {
                $documentType->setName($name);
                $model->edit($documentType);
            }
        } else {
            $documentType = new DocumentType();
            $documentType->setName($name);
            $documentType->setAgentId($agentId);

            $model->add($documentType);
        }

        Router::redirect("/settings/documenttypes");
    }

}