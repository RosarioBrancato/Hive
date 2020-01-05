<?php


namespace Controller;


use DTO\Document;
use Enumeration\EditType;
use Model\DocumentModel;
use Service\AuthServiceImpl;
use View\Layout\LayoutRendering;
use View\View;

class DocumentController
{
    /** @var DocumentModel */
    private $model;

    public function __construct()
    {
        $this->agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $this->model = new DocumentModel($this->agentId);
    }

    public function ShowHomePage()
    {
        $data = $this->model->getAll();

        $view = new View('DocumentView.php');
        $view->editType = EditType::View;
        $view->data = $data;
        LayoutRendering::ShowView($view);
    }

    public function ShowNewForm(Document $document)
    {
        $view = new View('DocumentViewEdit.php');
        $view->editType = EditType::Add;
        $view->document = $document;
        LayoutRendering::ShowView($view);
    }

}