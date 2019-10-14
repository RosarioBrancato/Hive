<?php

require_once("config/Autoloader.php");

use Model\LoginModel;
use View\View;
use Controller\LoginController;

$GLOBALS["ROOT_URL"] = "/hive/";

if(isset($_POST['username'])) {
    $model = new LoginModel();
    $view = new View('LoggedInViewTemp.php');
    $controller = new LoginController($model, $view);
    $controller->Login();

} else {
    $model = new LoginModel();
    $view = new View('LoginView.php');
    $controller = new LoginController($model, $view);
    $controller->ShowView();
}
