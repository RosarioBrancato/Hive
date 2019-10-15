<?php


namespace Controller;


use Model\LoginModel;
use View\Layout\LayoutRendering;
use View\View;

class LoginController
{

    public static function Index()
    {
        $view = new View('View/LoginView.php');
        LayoutRendering::ShowView($view);
    }

    public static function Login()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        //model
        $model = new LoginModel();
        $id = $model->GetUserId($username, $password);
        if ($id == -1) {
            $id = "Login data is incorrect!";
        }

        //view
        $view = new View('LoggedInViewTemp.php');
        $view->id = $id;
        LayoutRendering::ShowView($view);
    }

    public static function Logout() {
        session_destroy();
    }

}
