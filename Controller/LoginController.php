<?php


namespace Controller;


class LoginController extends _Controller
{

    function __construct($model, $view)
    {
        parent::__construct($model, $view);
    }

    public function Login() {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $id = $this->GetModel()->GetUserId($username, $password);
        if($id == -1) {
            $id = "Login data is incorrect!";
        }

        $this->GetView()->id = $id;
        $this->ShowView();
    }

}
