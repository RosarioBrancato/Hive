<?php


namespace Controller;


use DTO\ReportEntry;
use Enumeration\EditType;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Model\DocumentTypeModel;
use Router\Router;
use Service\AuthServiceImpl;
use Validator\DocumentTypeValidator;
use View\Layout\LayoutRendering;
use View\View;
use DTO\DocumentType;

class DocumentTypeController
{

    private $model = null;

    public function __construct()
    {
        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $this->model = new DocumentTypeModel($agentId);
    }

    public function ShowHomePage()
    {
        $types = $this->model->getAll();

        $view = new View('DocumentTypeView.php');
        $view->editType = EditType::View;
        $view->documentTypes = $types;
        LayoutRendering::ShowView($view);
    }

    public function ShowNewForm(DocumentType $documentType)
    {
        $documentTypes = $this->model->getAll();
        $nextNumber = $this->model->getNextFreeNumber();

        $documentType->setNumber($nextNumber);

        $view = new View('DocumentTypeView.php');
        $view->editType = EditType::Add;
        $view->documentTypes = $documentTypes;
        $view->documentType = $documentType;
        LayoutRendering::ShowView($view);
    }

    public function ShowEditForm(DocumentType $documentType)
    {
        $documentTypes = $this->model->getAll();
        $documentTypeReloaded = $this->model->get($documentType->getId());

        if (!empty($documentTypeReloaded)) {
            if (!empty($documentType->getNumber())) {
                $documentTypeReloaded->setNumber($documentType->getNumber());
            }
            if (!empty($documentType->getName())) {
                $documentTypeReloaded->setName($documentType->getName());
            }

            $view = new View('DocumentTypeView.php');
            $view->editType = EditType::Edit;
            $view->documentTypes = $documentTypes;
            $view->documentType = $documentTypeReloaded;
            LayoutRendering::ShowView($view);

        } else {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document type could not be found."));
            Router::redirect("/settings/documenttypes");
        }
    }

    public function ShowDeleteForm(string $id)
    {
        $documentTypes = $this->model->getAll();
        $documentType = $this->model->get($id);

        if (!empty($documentType)) {
            $view = new View('DocumentTypeView.php');
            $view->editType = EditType::Delete;
            $view->documentTypes = $documentTypes;
            $view->documentType = $documentType;
            LayoutRendering::ShowView($view);

        } else {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document type could not be found."));
            Router::redirect("/settings/documenttypes");
        }
    }

    public function InsertEntry(DocumentType $documentType)
    {
        $validator = new DocumentTypeValidator($this->model);
        $success = $validator->Validate($documentType);

        if ($success) {
            $success = $this->model->add($documentType);
            if (!$success) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "Document type could not be saved."));
            }
        }

        if ($success) {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, "Document type saved."));
        }

        return $success;
    }

    public function UpdateEntry(DocumentType $documentTypeUpdated)
    {
        $validator = new DocumentTypeValidator($this->model);
        $success = $validator->Validate($documentTypeUpdated);

        if ($success) {
            $documentType = $this->model->get($documentTypeUpdated->getId());

            if ($documentType != null) {
                $documentType->setNumber($documentTypeUpdated->getNumber());
                $documentType->setName($documentTypeUpdated->getName());

                $success = $this->model->edit($documentType);
                if (!$success) {
                    ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "Document type could not be saved."));
                }

            } else {
                $success = false;
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "Document type could not be found."));
            }
        }

        if ($success) {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, "Document type saved."));
        }

        return $success;
    }

    public function DeleteEntry(string $id)
    {
        $this->model->delete($id);
        ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, "Document type deleted."));
        Router::redirect("/settings/documenttypes");
    }

}