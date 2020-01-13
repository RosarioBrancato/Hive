<?php


namespace Controller;


use Model\AgentModel;
use Model\DashboardModel;
use Model\DocumentFieldModel;
use Service\AuthServiceImpl;
use View\Layout\LayoutRendering;
use View\View;

class DashboardController
{

    /** @var DashboardModel */
    private $model;

    /** @var int */
    private $agentId;

    public function __construct()
    {
        $this->agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $this->model = new DashboardModel($this->agentId);
    }

    public static function Home()
    {
        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $agentModel = new AgentModel();
        $agent = $agentModel->read($agentId);

        $documentFieldModel = new DocumentFieldModel($agentId);
        $documentFields = $documentFieldModel->getAllForStatistics();

        $view = new View('DashboardView.php');
        $view->agent = $agent;
        $view->documentFields = $documentFields;
        LayoutRendering::ShowView($view);
    }

    public function GetDocumentTypeStatistics()
    {
        $data = $this->model->getDocumentTypeStatistics();

        echo json_encode($data);
        exit;
    }

    public function GetCustomStatistics($documentField) {
        $data = $this->model->getCustomStatistics($documentField);

        echo json_encode($data);
        exit;
    }

}