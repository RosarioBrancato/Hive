<?php


namespace Controller;


use DTO\DocumentField;
use DTO\ReportEntry;
use Enumeration\EditType;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Model\DocumentFieldModel;
use Model\DocumentTypeModel;
use Router\Router;
use Service\AuthServiceImpl;
use Validator\DocumentFieldValidator;
use View\Layout\LayoutRendering;
use View\View;

class DocumentFieldController
{
    /** @var DocumentFieldModel */
    private $model;

    /** @var int */
    private $agentId;

    public function __construct()
    {
        $this->agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $this->model = new DocumentFieldModel($this->agentId);
    }

    public function ShowHomePage()
    {
        $data = $this->model->getAll();

        $view = new View('DocumentFieldView.php');
        $view->editType = EditType::View;
        $view->data = $data;
        $settingsMenu = new View('Layout/SettingsMenu.php');
        LayoutRendering::ShowView($view, $settingsMenu);
    }

    public function ShowNewForm(DocumentField $documentField)
    {
        //data for view
        $data = $this->model->getAll();

        //documenttypes for dropdown
        $documentTypeModel = new DocumentTypeModel($this->agentId);
        $documentTypes = $documentTypeModel->getAll();

        $nextNumber = $this->model->getNextFreeNumber();
        $documentField->setNumber($nextNumber);

        $view = new View('DocumentFieldView.php');
        $view->editType = EditType::Add;
        $view->data = $data;
        $view->documentField = $documentField;
        $view->documentTypes = $documentTypes;
        $settingsMenu = new View('Layout/SettingsMenu.php');
        LayoutRendering::ShowView($view, $settingsMenu);
    }

    public function ShowEditForm(DocumentField $documentField)
    {
        $documentFieldReloaded = $this->model->get($documentField->getId());


        if (!empty($documentFieldReloaded)) {
            $data = $this->model->getAll();

            //documenttypes for dropdown
            $documentTypeModel = new DocumentTypeModel($this->agentId);
            $documentTypes = $documentTypeModel->getAll();

            if (!empty($documentField->getNumber())) {
                $documentFieldReloaded->setNumber($documentField->getNumber());
            }
            if (!empty($documentField->getLabel())) {
                $documentFieldReloaded->setLabel($documentField->getLabel());
            }
            if (!empty($documentField->getFieldType())) {
                $documentFieldReloaded->setFieldType($documentField->getFieldType());
            }
            if (!empty($documentField->getDocumentTypeId())) {
                $documentFieldReloaded->setDocumentTypeId($documentField->getDocumentTypeId());
            }

            $view = new View('DocumentFieldView.php');
            $view->editType = EditType::Edit;
            $view->data = $data;
            $view->documentField = $documentFieldReloaded;
            $view->documentTypes = $documentTypes;
            $settingsMenu = new View('Layout/SettingsMenu.php');
            LayoutRendering::ShowView($view, $settingsMenu);

        } else {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document field could not be found."));
            Router::redirect("/settings/documentfields");
        }
    }

    public function ShowDeleteForm(string $id)
    {
        $data = $this->model->getAll();
        $documentField = $this->model->get($id);
        //documenttypes for dropdown
        $documentTypeModel = new DocumentTypeModel($this->agentId);
        $documentTypes = $documentTypeModel->getAll();

        if (!empty($documentField)) {
            $view = new View('DocumentFieldView.php');
            $view->editType = EditType::Delete;
            $view->data = $data;
            $view->documentField = $documentField;
            $view->documentTypes = $documentTypes;
            $settingsMenu = new View('Layout/SettingsMenu.php');
            LayoutRendering::ShowView($view, $settingsMenu);

        } else {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document field could not be found."));
            Router::redirect("/settings/documentfields");
        }
    }

    public function InsertEntry(DocumentField $documentField)
    {
        $validator = new DocumentFieldValidator($this->model);
        $success = $validator->Validate($documentField);

        if ($success) {
            $success = $this->model->add($documentField);
            if (!$success) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "Document field could not be saved."));
            }
        }

        if ($success) {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, "Document field saved."));
        }

        return $success;
    }

    public function UpdateEntry(DocumentField $documentFieldUpdated)
    {
        $validator = new DocumentFieldValidator($this->model);
        $success = $validator->Validate($documentFieldUpdated);

        if ($success) {
            $documentField = $this->model->get($documentFieldUpdated->getId());

            if ($documentField != null) {
                $success = $this->model->edit($documentFieldUpdated);
                if (!$success) {
                    ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "Document field could not be saved."));
                }

            } else {
                $success = false;
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "Document field could not be found."));
            }
        }

        if ($success) {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, "Document field saved."));
        }

        return $success;
    }

    public function DeleteEntry(int $id)
    {
        $success = $this->model->delete($id);

        if ($success) {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, "Document field deleted."));
        } else {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "Document field could not be deleted."));
        }

        return $success;
    }

}