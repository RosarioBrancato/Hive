<?php


namespace Controller;


use DTO\Document;
use DTO\DocumentField;
use DTO\DocumentFieldValue;
use DTO\DocumentFile;
use DTO\ReportEntry;
use Enumeration\EditType;
use Enumeration\FieldType;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Model\DocumentFieldModel;
use Model\DocumentFieldValueModel;
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

    public function ShowDetails(int $id, int $editType = null)
    {
        if (empty($editType)) {
            $editType = EditType::View;
        } else if ($editType == EditType::Add) {
            $this->ShowNewForm();
            exit;
        }

        $document = $this->model->get($id);

        if (!empty($document)) {
            $documentTypesModel = new DocumentTypeModel($this->agentId);
            $documentTypes = $documentTypesModel->getAll();

            $documentFileModel = new DocumentFileModel($this->agentId);
            $documentFile = $documentFileModel->getByDocumentId($document->getId());

            $documentFieldValueModel = new DocumentFieldValueModel($this->agentId);
            $documentFieldValues = $documentFieldValueModel->getByDocumentId($document->getId());

            $view = new View('DocumentViewEdit.php');
            $view->editType = $editType;
            $view->document = $document;
            $view->documentFile = $documentFile;
            $view->documentTypes = $documentTypes;
            $view->documentFieldValues = $documentFieldValues;
            LayoutRendering::ShowView($view);

        } else {
            ReportHelper::AddEntryArgs(ReportEntryLevel::Error, "Document ID not found.");
            Router::redirect("/documents");
        }
    }

    public function ShowNewForm()
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

    /**
     * @param $document Document
     * @param $documentFiles DocumentFile[]
     * @param $documentFieldValues DocumentFieldValue[]
     */
    public function InsertDocument($document, $documentFiles, $documentFieldValues)
    {
        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $model = new DocumentModel($agentId);
        $documentFieldModel = new DocumentFieldModel($agentId);

        //Convert field to field values
        $documentFields = $documentFieldModel->getAllByDocumentTypeId($document->getDocumenttypeid());
        $documentFieldValuesInternal = $this->convertFieldsToFieldsValue($documentFields);

        foreach ($documentFieldValuesInternal as $internal) {
            foreach ($documentFieldValues as $incomming) {
                if ($internal->getLabel() === str_replace("_", " ", $incomming->getLabel())) {

                    switch ($internal->getFieldType()) {
                        case FieldType::TextField:
                            $internal->setStringValue($incomming->getStringValue());
                            break;
                        case FieldType::DateField:
                            $internal->setDateValue($incomming->getStringValue());
                            break;
                        case FieldType::NumberField:
                            $internal->setIntValue($incomming->getStringValue());
                            break;
                        case FieldType::DecimalField:
                            $internal->setDecimalValue($incomming->getStringValue());
                            break;
                        case FieldType::CheckBox:
                            $bool = !empty($incomming->getStringValue());
                            $internal->setBoolValue($bool);
                            break;
                    }

                }
            }
        }

        //var_dump($documentFieldValues);
        //var_dump($documentFieldValuesInternal);

        //VALIDATE
        $validator = new DocumentValidator($model);
        $success = $validator->Validate($document);

        $validatorFile = new DocumentFileValidator();
        foreach ($documentFiles as $documentFile) {
            $success &= $validatorFile->Validate($documentFile);
        }

        $validatorFieldValue = new DocumentFieldValueValidator();
        foreach ($documentFieldValuesInternal as $documentFieldValue) {
            $success &= $validatorFieldValue->Validate($documentFieldValue);
        }

        //INSERT
        if ($success) {
            $success = $model->add($document, $documentFiles, $documentFieldValuesInternal);

            if ($success) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, 'Document added.'));
            } else {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, 'Error occured.'));
            }
        }

        Router::redirect("/documents");
    }

    public function UpdateDocument()
    {

    }

    public function DeleteDocument($id)
    {
        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $model = new DocumentModel($agentId);

        $success = $model->delete($id);

        if ($success) {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, 'Document deleted.'));
        } else {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, 'Document could not be deleted.'));
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