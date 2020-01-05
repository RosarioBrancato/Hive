<?php


namespace Controller;


use DTO\Document;
use DTO\DocumentField;
use DTO\DocumentFieldValue;
use Enumeration\EditType;
use Model\DocumentFieldModel;
use Model\DocumentModel;
use Model\DocumentTypeModel;
use Service\AuthServiceImpl;
use View\Layout\LayoutRendering;
use View\View;

class DocumentController
{
    /** @var DocumentModel */
    private $model;

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

    public function ShowNewForm(Document $document)
    {
        $documentTypeModel = new DocumentTypeModel($this->agentId);
        $documentTypes = $documentTypeModel->getAll();

        // select documentfields
        $documentFieldValues = array();
        if(sizeof($documentTypes) > 0) {
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