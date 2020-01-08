<?php


namespace Controller;


use DTO\Document;
use DTO\DocumentField;
use DTO\DocumentFieldValue;
use DTO\ReportEntry;
use Enumeration\EditType;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Model\DocumentFieldModel;
use Model\DocumentFileModel;
use Model\DocumentModel;
use Model\DocumentTypeModel;
use Router\Router;
use Service\AuthServiceImpl;
use Util\DocumentFieldsGenerator;
use Validator\DocumentFieldValueValidator;
use Validator\DocumentFileValidator;
use Validator\DocumentValidator;
use View\Layout\LayoutRendering;
use View\View;

class DocumentController
{
    /** @var DocumentModel */
    private $model;

    private $agentId;

    public function __construct()
    {
        $this->agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $this->model = new DocumentModel($this->agentId);
    }

    public function ShowHomePage()
    {
        $data = $this->model->getAll();

        $view = new View('DocumentView.php');
        $view->editType = EditType::View;
        $view->data = $data;
        LayoutRendering::ShowView($view);
    }

    public function ShowDetails(int $id)
    {
        $document = $this->model->get($id);

        $documentTypesModel = new DocumentTypeModel($this->agentId);
        $documentTypes = $documentTypesModel->getAll();

        $documentFileModel = new DocumentFileModel($this->agentId);
        $documentFile = $documentFileModel->getByDocumentId($document->getId());

        if (!empty($document)) {
            $view = new View('DocumentViewEdit.php');
            $view->editType = EditType::View;
            $view->document = $document;
            $view->documentFile = $documentFile;
            $view->documentTypes = $documentTypes;
            LayoutRendering::ShowView($view);

        } else {
            Router::redirect("/documents");
        }
    }

    public function ShowNewForm(Document $document)
    {
        $documentTypeModel = new DocumentTypeModel($this->agentId);
        $documentTypes = $documentTypeModel->getAll();

        // select documentfields
        $documentFieldValues = array();
        if (sizeof($documentTypes) > 0) {
            $documentTypeId = $documentTypes[0]->getId();

            $documentFieldModel = new DocumentFieldModel($this->agentId);
            $documentFields = $documentFieldModel->getAllByDocumentTypeId($documentTypeId);
            $documentFieldValues = $this->convertFieldsToFieldsValue($documentFields);
        }

        $view = new View('DocumentViewEdit.php');
        $view->editType = EditType::Add;
        $view->document = $document;
        $view->documentTypes = $documentTypes;
        $view->documentFieldValues = $documentFieldValues;
        LayoutRendering::ShowView($view);
    }

    public function GetDocumentFieldValues($documentTypeId)
    {
        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $model = new DocumentFieldModel($agentId);
        $documentFields = $model->getAllByDocumentTypeId($documentTypeId);
        $documentFieldValues = $this->convertFieldsToFieldsValue($documentFields);

        foreach ($documentFieldValues as $documentFieldValue) {
            DocumentFieldsGenerator::GenerateInputTags($documentFieldValue);
        }
    }

    public function InsertDocument($document, $documentFiles, $documentFieldValues)
    {
        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $model = new DocumentModel($agentId);

        //VALIDATE
        $validator = new DocumentValidator($model);
        $success = $validator->Validate($document);

        $validatorFile = new DocumentFileValidator();
        foreach ($documentFiles as $documentFile) {
            $success &= $validatorFile->Validate($documentFile);
        }

        $validatorFieldValue = new DocumentFieldValueValidator();
        foreach ($documentFieldValues as $documentFieldValue) {
            $success &= $validatorFieldValue->Validate($documentFieldValue);
        }

        //INSERT
        if ($success) {
            $success = $model->add($document, $documentFiles, $documentFieldValues);
        }

        if ($success) {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, 'Document added.'));
        } else {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, 'Error occured.'));
        }

        Router::redirect("/documents");
    }


    /**
     * @param $documentFields DocumentField[]
     * @return array
     */
    private function convertFieldsToFieldsValue($documentFields)
    {
        $documentFieldValues = array();

        foreach ($documentFields as $documentField) {
            $documentFieldValue = new DocumentFieldValue();
            $documentFieldValue->setNumber($documentField->getNumber());
            $documentFieldValue->setLabel($documentField->getLabel());
            $documentFieldValue->setFieldType($documentField->getFieldType());

            array_push($documentFieldValues, $documentFieldValue);
        }

        return $documentFieldValues;
    }

}