<?php
/**
 * Created by PhpStorm.
 * User: leeko
 * Date: 08/01/2020
 * Time: 23:53
 */

namespace Controller;

use Model\AgentModel;
use Model\ProfileModel;
use Service\AuthServiceImpl;
use View\Layout\LayoutRendering;
use View\View;

class ProfileController
{
    /** @var ProfileModel */
    private $model;

    /** @var int */
    private $agentId;


    public function __construct()
    {
        $this->agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $this->model = new ProfileModel($this->agentId);
    }


    public function ShowHomeView()
    {
        $agent = $this->model->get($this->agentId);

        $view = new View('ProfileView.php');
        $view->agent = $agent;
        LayoutRendering::ShowView($view);
    }
}