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
        $documentFieldModel = new DocumentFieldModel($this->agentId);

        //Convert field to field values
        $documentFields = $documentFieldModel->getAllByDocumentTypeId($document->getDocumenttypeid());
        $documentFieldValuesInternal = $this->convertFieldsToFieldsValue($documentFields);

        $this->setValuesDocumentFieldValueDst($documentFieldValuesInternal, $documentFieldValues);

        //VALIDATE
        $validator = new DocumentValidator($this->model);
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
            $success = $this->model->add($document, $documentFiles, $documentFieldValuesInternal);

            if ($success) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, 'Document added.'));
            } else {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, 'Error occured.'));
            }
        }

        Router::redirect("/documents");
    }

    /**
     * @param $document Document
     * @param $documentFiles DocumentFile[]
     * @param $documentFieldValues DocumentFieldValue[]
     */
    public function UpdateDocument($document, $documentFiles, $documentFieldValues)
    {
        $documentFieldModel = new DocumentFieldModel($this->agentId);
        $documentFieldValueModel = new DocumentFieldValueModel($this->agentId);

        //if document type changed => delete field values
        $documentInternal = $this->model->get($document->getId());
        if (!empty($documentInternal) && $documentInternal->getDocumenttypeid() != $document->getDocumenttypeid()) {
            $documentFieldValueModel->deleteByDocumentId($document->getId());
        }

        $documentFieldValuesToUpdate = $documentFieldValueModel->getByDocumentId($document->getId());

        //Convert field to field values
        $documentFields = $documentFieldModel->getAllByDocumentTypeId($document->getDocumenttypeid());
        $documentFieldValuesInternal = $this->convertFieldsToFieldsValue($documentFields);


        // add potentially missing document field values
        $toAdd = array();
        foreach ($documentFieldValuesInternal as $internal) {
            $found = false;

            foreach ($documentFieldValuesToUpdate as $toUpdate) {
                if ($internal->getLabel() === $toUpdate->getLabel()) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                array_push($toAdd, $internal);
            }
        }

        foreach ($toAdd as $entry) {
            array_push($documentFieldValuesToUpdate, $entry);
        }

        // set values from post
        $this->setValuesDocumentFieldValueDst($documentFieldValuesToUpdate, $documentFieldValues);


        //VALIDATE
        $validator = new DocumentValidator($this->model);
        $success = $validator->Validate($document);

        $validatorFile = new DocumentFileValidator();
        foreach ($documentFiles as $documentFile) {
            $success &= $validatorFile->Validate($documentFile);
        }

        $validatorFieldValue = new DocumentFieldValueValidator();
        foreach ($documentFieldValuesToUpdate as $documentFieldValue) {
            $success &= $validatorFieldValue->Validate($documentFieldValue);
        }

        //var_dump($success);
        //var_dump($document);
        //var_dump($documentFiles);
        //var_dump($documentFieldValuesToUpdate);

        //UPDATE
        if ($success) {
            $success = $this->model->update($document, $documentFiles, $documentFieldValuesToUpdate);

            if ($success) {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, 'Document added.'));
            } else {
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, 'Error occured.'));
            }
        }

        Router::redirect("/documents");
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

    /**
     * @param $documentFieldValuesDst DocumentFIeldValue[]
     * @param $documentFieldValuesSrc DocumentFIeldValue[]
     */
    private function setValuesDocumentFieldValueDst($documentFieldValuesDst, $documentFieldValuesSrc)
    {
        foreach ($documentFieldValuesDst as $dst) {
            $found = false;

            foreach ($documentFieldValuesSrc as $src) {
                if ($dst->getLabel() === str_replace("_", " ", $src->getLabel())) {
                    $dst->setBoolValue(null);
                    $dst->setIntValue(null);
                    $dst->setDecimalValue(null);
                    $dst->setStringValue(null);
                    $dst->setDateValue(null);


                    switch ($dst->getFieldType()) {
                        case FieldType::TextField:
                            $dst->setStringValue($src->getStringValue());
                            break;
                        case FieldType::DateField:
                            $dst->setDateValue($src->getStringValue());
                            break;
                        case FieldType::NumberField:
                            $dst->setIntValue(intval($src->getStringValue()));
                            break;
                        case FieldType::DecimalField:
                            $dst->setDecimalValue(floatval($src->getStringValue()));
                            break;
                        case FieldType::CheckBox:
                            $bool = !empty($src->getStringValue());
                            $dst->setBoolValue($bool);
                            break;
                    }

                    $found = true;
                    break;
                }
            }

            // checkbox was not in post array --> it was unchecked in the form
            if (!$found && $dst->getFieldType() == FieldType::CheckBox) {
                $dst->setBoolValue(false);
                $dst->setIntValue(null);
                $dst->setDecimalValue(null);
                $dst->setStringValue(null);
                $dst->setDateValue(null);
            }
        }
    }

}