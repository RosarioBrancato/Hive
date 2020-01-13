<?php


namespace Test;


use Controller\DocumentController;
use DateTime;
use DateTimeZone;
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
        //$this->TestControllerNew();


        //$this->TestControllerUpdate();
        //$this->TestIntVal();

        $this->TestTimezone();
    }

    private function TestIntVal()
    {
        $intVal = intval("");
        var_dump($intVal);

        $floatVal = floatval("");
        var_dump($floatVal);
    }

    public function TestTimezone()
    {
        $model = new DocumentModel($this->agentId);
        $document = $model->get(96);

        var_dump($document);

        $tz = 'Europe/London';

        $dt = new DateTime($document->getCreated(), new DateTimeZone('UTC'));
        echo $dt->format('d.m.Y H:i:s') . " ";

        $dt->setTimezone(new DateTimeZone('Europe/Amsterdam'));
        echo $dt->format('d.m.Y H:i:s');
    }

    private function TestControllerUpdate()
    {
        $document = new Document();
        $document->setId(87);
        $document->setTitle("Test EDIT 2 UNIT");
        $document->setDocumenttypeid(1);

        $documentFiles = array();

        $documentFieldValues = array();

        $fieldValue1 = new DocumentFieldValue();
        $fieldValue1->setId(27);
        $fieldValue1->setDocumentId(87);
        $fieldValue1->setNumber(1);
        $fieldValue1->setLabel("Payed");
        $fieldValue1->setFieldType(1);
        $fieldValue1->setDateValue("2020-08-01 00:00:00");
        array_push($documentFieldValues, $fieldValue1);

        $fieldValue2 = new DocumentFieldValue();
        $fieldValue2->setId(28);
        $fieldValue2->setDocumentId(87);
        $fieldValue2->setNumber(2);
        $fieldValue2->setLabel("Comment");
        $fieldValue2->setFieldType(0);
        $fieldValue2->setStringValue("this is a short comment");
        array_push($documentFieldValues, $fieldValue2);

        $fieldValue3 = new DocumentFieldValue();
        $fieldValue3->setId(29);
        $fieldValue3->setDocumentId(87);
        $fieldValue3->setNumber(6);
        $fieldValue3->setLabel("Amount");
        $fieldValue3->setFieldType(3);
        $fieldValue3->setDecimalValue("12.3");
        array_push($documentFieldValues, $fieldValue3);

        $fieldValue4 = new DocumentFieldValue();
        $fieldValue4->setId(30);
        $fieldValue4->setDocumentId(87);
        $fieldValue4->setNumber(7);
        $fieldValue4->setLabel("# of Copies");
        $fieldValue4->setFieldType(2);
        $fieldValue4->setIntValue("");
        array_push($documentFieldValues, $fieldValue4);

        $fieldValue5 = new DocumentFieldValue();
        $fieldValue5->setId(31);
        $fieldValue5->setDocumentId(87);
        $fieldValue5->setNumber(8);
        $fieldValue5->setLabel("Done?");
        $fieldValue4->setFieldType(4);
        array_push($documentFieldValues, $fieldValue5);

        $model = new DocumentModel(1);
        $success = $model->update($document, $documentFiles, $documentFieldValues);

        var_dump($success);
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