<?php


namespace Controller;

include_once('Controller/_Controller.php');

class LoginController extends _Controller
{

    function __construct($model, $view)
    {
        parent::__construct($model, $view);
    }

    protected function GetTestString()
    {
        return "Lower class";
    }

    public function ShowString()
    {
        $val = parent::GetTestString();
        $val2 = $this::GetTestString();
        echo "<p>$val</p>";
        echo "<p>$val2</p>";
    }

}
