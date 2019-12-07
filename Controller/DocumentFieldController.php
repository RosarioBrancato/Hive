<?php


namespace Controller;


use Enumeration\EditType;
use Model\DocumentFieldModel;
use Service\AuthServiceImpl;
use View\Layout\LayoutRendering;
use View\View;

class DocumentFieldController
{

    private $model = null;

    public function __construct()
    {
        $agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $this->model = new DocumentFieldModel($agentId);
    }

    public function ShowHomePage()
    {
        $data = $this->model->getAll();

        $view = new View('DocumentFieldView.php');
        $view->editType = EditType::View;
        $view->data = $data;
        LayoutRendering::ShowView($view);
    }

}