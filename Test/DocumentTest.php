<?php


namespace Test;


use DTO\Document;
use DTO\DocumentFieldValue;
use DTO\DocumentFile;
use Enumeration\FieldType;
use Model\DocumentModel;

class DocumentTest
{

    private $agentId;

    public function Execute()
    {
        $this->agentId = 1;

        $this->TestInsert();
    }

    private function TestInsert()
    {
        echo "INSERT" . PHP_EOL;
        $documentTypeId = 11;

        $document = new Document();
        $document->setTitle('My Doc Unit Test');
        $document->setDocumenttypeid($documentTypeId);
        $document->setAgentid($this->agentId);

        $fieldValue = new DocumentFieldValue();
        $fieldValue->setNumber(1);
        $fieldValue->setLabel('Amount');
        $fieldValue->setFieldType(FieldType::NumberField);
        $fieldValue->setDecimalValue(8.25);

        $file = new DocumentFile();
        $file->setFilename('01 Introduction to PHP I.pdf');
        if ($stream = fopen('D:\\Temp\\01 Introduction to PHP I.pdf', "r")) {
            $file->setFilecontent(utf8_encode(stream_get_contents($stream)));
            fclose($stream);
        }

        $fieldValues = array();
        array_push($fieldValues, $fieldValue);

        $files = array();
        array_push($files, $file);

        $model = new DocumentModel($this->agentId);
        $success = $model->add($document, $files, $fieldValues);

        var_dump($success);
    }

}