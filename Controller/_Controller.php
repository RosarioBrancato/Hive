<?php


namespace Controller;


use View\Layout\LayoutRendering;


abstract class _Controller
{

    private $model = null;
    private $view = null;

    function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function ShowView() {
        LayoutRendering::basicLayout($this->view);
    }

    protected function GetModel() {
        return $this->model;
    }

    protected  function GetView() {
        return $this->view;
    }

}
