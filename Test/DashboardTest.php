<?php


namespace Test;


use Model\DashboardModel;

class DashboardTest
{
    public function Execute()
    {
        $this->TestDocumentTypeStatistic();
    }

    private function TestDocumentTypeStatistic()
    {
        $model = new DashboardModel(1);
        $data = $model->getDocumentTypeStatistics();
        $json = json_encode($data);

        var_dump($json);
    }

}