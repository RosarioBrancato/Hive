<?php


namespace Test;


use DTO\DocumentField;
use Model\DocumentFieldModel;
use Model\DocumentTypeModel;

class DocumentFieldTest
{
    /** @var DocumentFieldModel */
    private $model = null;
    private $agentId;

    public function Execute()
    {
        $agentId = 1;
        $this->agentId = $agentId;
        $this->model = new DocumentFieldModel($agentId);

        /*
        $this->TestGetAll();
        $this->TestGet();
        $this->TestGetNextFreeNumber();
        $this->TestIsLabelUnique();
        */
        //$this->TestAdd();
        //$this->TestCRUD();
        //$this->TestCheckAgentId();
        //$this->TestGetAllDocumentTypeId();
        $this->TestStatistics();
    }

    private function TestStatistics() {
        $fields = $this->model->getAllForStatistics();

        var_dump($fields);
    }

    private function TestGetAll()
    {
        echo "getAll" . PHP_EOL;
        var_dump($this->model->getAll());
    }

    private function TestGet()
    {
        $id = 1;

        echo "get" . PHP_EOL;
        var_dump($this->model->get($id));
    }

    private function TestGetNextFreeNumber()
    {
        echo "getNextFreeNumber" . PHP_EOL;
        var_dump($this->model->getNextFreeNumber(1));
    }

    private function TestIsLabelUnique()
    {
        $label = "Title";

        echo "isLabelUnique" . PHP_EOL;
        var_dump($this->model->isLabelUnique($label, 1));
    }

    private function TestAdd()
    {
        echo "add" . PHP_EOL;

        $documentField = new DocumentField();
        $documentField->setNumber(1);
        $documentField->setLabel("Unit Test");
        $documentField->setFieldType(2);
        $documentField->setDocumentTypeId(1);

        $success = $this->model->add($documentField);
        var_dump($success);
    }

    private function TestCheckAgentId()
    {
        echo "checkAgentId" . PHP_EOL;
        $success = $this->model->checkAgentId(8);
        var_dump($success);
    }

    private function TestCRUD()
    {
        echo "CRUD" . PHP_EOL;

        $documentTypeId = 1;
        $label = "Unit Test";
        $fieldType = 2;
        $nextNumber = $this->model->getNextFreeNumber($documentTypeId);

        $documentField = new DocumentField();
        $documentField->setNumber($nextNumber);
        $documentField->setLabel($label);
        $documentField->setFieldType($fieldType);
        $documentField->setDocumentTypeId($documentTypeId);
        echo "data" . PHP_EOL;
        var_dump($documentField);

        $success = $this->model->add($documentField);
        echo "add" . PHP_EOL;
        var_dump($success);

        $id = $documentField->getId();
        $documentField = $this->model->get($id);
        echo "get" . PHP_EOL;
        var_dump($documentField);

        $documentField->setLabel($documentField->getLabel() . " EDIT");
        $success = $this->model->edit($documentField);
        echo "edit" . PHP_EOL;
        var_dump($success);
        var_dump($documentField);

        $success = $this->model->delete($documentField->getId());
        echo "delete" . PHP_EOL;
        var_dump($success);
    }

    private function TestGetAllDocumentTypeId()
    {
        echo "GET ALL" . PHP_EOL;

        $documentTypeModel = new DocumentTypeModel($this->agentId);
        $documentTypes = $documentTypeModel->getAll();
        $documentTypeId = $documentTypes[0]->getId();

        $documentFields = $this->model->getAllByDocumentTypeId($documentTypeId);
        //$documentFieldValues = $this->convertFieldsToFieldsValue($documentFields);

        var_dump($documentFields);
    }

}