<?php


namespace Controller;


abstract class _Controller
{

    private $model = null;
    private $view = null;

    function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    protected function GetTestString()
    {
        return "Upper class";
    }

    public function ShowView() {
        $this->view->render();
    }

}
