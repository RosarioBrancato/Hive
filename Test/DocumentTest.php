<?php


namespace Test;


use Controller\DocumentController;
use DTO\Document;
use DTO\DocumentFieldValue;
use DTO\DocumentFile;
use Enumeration\FieldType;
use Model\DocumentFileModel;
use Model\DocumentModel;
use Service\AuthServiceImpl;

class DocumentTest
{

    private $agentId;

    public function Execute()
    {
        $this->agentId = 1;

        //$this->TestInsert();
        //$this->TestGetFile();
        //$this->TestStreamWrite();

        //$this->TestInsertNew();
        $this->TestControllerNew();
    }

    private function TestControllerNew()
    {
        echo "INSERT FROM CONTROLLER" . PHP_EOL;

        AuthServiceImpl::getInstance()->verifyAgent("rosario@test.ch", "1234");

        $documentTypeId = 22;
        $pathToFile = 'D:\\Temp\\logistics_2_strategic_questions.pdf';


        $document = new Document();
        $document->setTitle('My Doc Unit Test DAY 2.2');
        $document->setDocumenttypeid($documentTypeId);
        $document->setAgentid($this->agentId);

        $filecontents = array();
        $filecontent = new DocumentFile();
        $filecontent->setFilename("no file name");
        $filecontent->setPathToFile($pathToFile);
        array_push($filecontents, $filecontent);

        $fieldValues = array();
        $documentFieldValue = new DocumentFieldValue();
        $documentFieldValue->setLabel('are you good');
        $documentFieldValue->setStringValue("true");
        array_push($fieldValues, $documentFieldValue);


        $controller = new DocumentController();
        $controller->InsertDocument($document, $filecontents, $fieldValues);
    }

    private function TestInsert()
    {
        echo "INSERT" . PHP_EOL;
        $documentTypeId = 11;

        $document = new Document();
        $document->setTitle('My Doc Unit Test DAY 2');
        $document->setDocumenttypeid($documentTypeId);
        $document->setAgentid($this->agentId);

        $fieldValue = new DocumentFieldValue();
        $fieldValue->setNumber(1);
        $fieldValue->setLabel('Amount');
        $fieldValue->setFieldType(FieldType::NumberField);
        $fieldValue->setDecimalValue(8.25);

        $file = new DocumentFile();
        $file->setFilename('logistics_2_strategic_questions DAY 2.pdf');

        /*if ($stream = fopen('D:\\Temp\\logistics_2_strategic_questions.pdf', "r")) {
            $file->setFilecontent(utf8_encode(stream_get_contents($stream)));
            fclose($stream);
        }*/
        $file->setFilecontent(file_get_contents("D:\\Temp\\logistics_2_strategic_questions.pdf"));
        //$filename = 'D:\\Temp\\01 Introduction to PHP I.pdf';
        //$file->setFilecontent(readfile($filename));

        $fieldValues = array();
        array_push($fieldValues, $fieldValue);

        $files = array();
        array_push($files, $file);

        $model = new DocumentModel($this->agentId);
        $success = $model->add($document, $files, $fieldValues);

        var_dump($success);
    }

    private function TestGetFile()
    {
        echo "GET FILE" . PHP_EOL;

        $model = new DocumentFileModel($this->agentId);
        $documentFile = $model->get(1);

        //$mystream = utf8_decode($documentFile->getFilecontent());

        //echo get_resource_type($documentFile->getFilecontent());


        //fwrite($mystream, "D:\\Temp\\Unit Test File.pdf");
        //$file = fopen("D:\\Temp\\Unit Test File.pdf", "w");
        //fwrite($file, utf8_decode($documentFile->getFilecontent()));
        //fclose($file);

        //file_put_contents("D:\\Temp\\Unit Test File.pdf", $documentFile->getFilecontent());

        //var_dump($documentFile);
        echo "STREAM 1" . PHP_EOL;
        //echo file_get_contents('D:\\Temp\\logistics_2_strategic_questions.pdf');
        echo stream_get_contents($documentFile->getFilecontent());
        //$file = fopen("D:\\Temp\\logistics_2_strategic_questions.pdf", "r");
        //echo $file;
        //fclose($file);

        //mb_convert_encoding()


        //echo $mystream;
        //echo utf8_decode(fread($documentFile->getFilecontent(), (134217728 / 8)));
        //echo "STREAM 2" . PHP_EOL;
        //echo stream_get_contents(utf8_decode($documentFile->getFilecontent()));

        //echo "STREAM 2" . PHP_EOL;
        //echo stream_get_contents($documentFile->getFilecontent());
        //if ($stream = fopen('D:\\Temp\\01 Introduction to PHP I.pdf', "r")) {
        //$file->setFilecontent(utf8_encode(stream_get_contents($stream)));
        //echo stream_get_contents($stream);
        //$file->setFilecontent($stream);
        //echo $stream;
        //    fclose($stream);
        //}
    }

    private function TestStreamWrite()
    {
        $string = 'Some bad-ass string';

        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $string);
        rewind($stream);

        echo stream_get_contents($stream);
    }

    private function TestInsertNew()
    {
        $pathToFile = 'D:\\Temp\\logistics_2_strategic_questions.pdf';

        $documentFile = new DocumentFile();
        $documentFile->setDocumentid(55);
        $documentFile->setFilename('PLEASE WORK.pdf');
        $documentFile->setPathToFile($pathToFile);

        $model = new DocumentFileModel($this->agentId);
        $id = $model->add($documentFile);
        var_dump($id);
    }

}