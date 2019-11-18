<?php


namespace Controller;


use Model\AgentModel;
use Service\AuthServiceImpl;
use View\Layout\LayoutRendering;
use View\View;

class DashboardController
{

    public static function Home()
    {
        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $agentModel = new AgentModel();
        $agent = $agentModel->read($agentId);

        $view = new View('DashboardHome.php');
        $view->agent = $agent;
        LayoutRendering::ShowView($view);
    }

}