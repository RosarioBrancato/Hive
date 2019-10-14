<?php

use View\View;
use Model\LoginModel;
use Controller\LoginController;

require_once ('Model/LoginModel.php');
require_once ('View/View.php');
require_once ('Controller/LoginController.php');


$model = new LoginModel();
$view = new View('./View/LoginView.php');
$controller = new LoginController($model, $view);
echo 'Test';
echo $controller->ShowView();
echo 'Test2';
