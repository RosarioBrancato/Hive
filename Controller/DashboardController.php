<?php


namespace Controller;


use Model\AgentModel;
use Model\DashboardModel;
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

        $view = new View('DashboardHome.php');
        $view->agent = $agent;
        LayoutRendering::ShowView($view);
    }

    public function GetDocumentTypeStatistics()
    {
        $data = $this->model->getDocumentTypeStatistics();

        echo json_encode($data);
        exit;
    }

}