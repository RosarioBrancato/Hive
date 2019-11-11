<?php


namespace Controller;


use Model\DocumentTypeModel;
use View\Layout\LayoutRendering;
use View\View;

class DocumentTypeController
{

    public static function Home()
    {
        $agentid = $_SESSION["agentLogin"]["agent"]->getId();

        $model = new DocumentTypeModel();
        $types = $model->getAll($agentid);

        $view = new View('DocumentTypeView.php');
        $view->documenttypes = $types;
        LayoutRendering::ShowView($view);
    }

}