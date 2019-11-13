<?php


namespace Controller;


use Model\DocumentTypeModel;
use View\Layout\LayoutRendering;
use View\View;

class DocumentTypeController
{

    public static function Home()
    {
        $agentId = $_SESSION["agentLogin"]["agent"]->getId();

        $model = new DocumentTypeModel();
        $types = $model->getAll($agentId);

        $view = new View('DocumentTypeView.php');
        $view->documentTypes = $types;
        LayoutRendering::ShowView($view);
    }

}