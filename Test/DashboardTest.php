<?php


namespace Test;


use DTO\DocumentField;
use DTO\DocumentFieldValue;
use Enumeration\FieldType;
use Model\DashboardModel;
use Model\DocumentFieldValueModel;

class DashboardTest
{
    public function Execute()
    {
        //$this->TestDocumentTypeStatistic();
        $this->TestCustomStatistics3();
    }

    private function TestCustomStatistics()
    {
        $fieldValue = new DocumentField();
        $fieldValue->setLabel("Done?");
        $fieldValue->setFieldType(FieldType::CheckBox);

        $model = new DashboardModel(1);
        $data = $model->getCustomStatistics($fieldValue);

        var_dump($data);
    }

    private function TestCustomStatistics2()
    {
        $fieldValue = new DocumentField();
        $fieldValue->setLabel("# of Copies");
        $fieldValue->setFieldType(FieldType::NumberField);

        $model = new DashboardModel(1);
        $data = $model->getCustomStatistics($fieldValue);

        var_dump($data);
    }

    private function TestCustomStatistics3()
    {
        $fieldValue = new DocumentField();
        $fieldValue->setLabel("Amount");
        $fieldValue->setFieldType(FieldType::DecimalField);

        $model = new DashboardModel(1);
        $data = $model->getCustomStatistics($fieldValue);

        var_dump($data);
    }

    private function TestDocumentTypeStatistic()
    {
        $model = new DashboardModel(1);
        $data = $model->getDocumentTypeStatistics();
        $json = json_encode($data);

        var_dump($json);
    }

}