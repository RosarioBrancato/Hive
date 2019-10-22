<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 09.10.2017
 * Time: 08:30
 */

namespace Controller;

use DTO\Agent;
use Service\AuthServiceImpl;
use Validator\AgentValidator;
use View\Layout\LayoutRendering;
use View\View;


class AuthController
{

    public static function ShowLoginView()
    {
        $view = new View('LoginView.php');
        LayoutRendering::ShowView($view);
    }

    public static function ShowRegisterView($agent = null, $agentValidator = null)
    {
        $view = new View('RegisterView.php');
        $view->agent = $agent;
        $view->agentValidator = $agentValidator;
        LayoutRendering::ShowView($view);
    }

    public static function authenticate()
    {
        if (isset($_SESSION["agentLogin"])) {
            if (AuthServiceImpl::getInstance()->validateToken($_SESSION["agentLogin"]["token"])) {
                return true;
            }
        }
        if (isset($_COOKIE["token"])) {
            if (AuthServiceImpl::getInstance()->validateToken($_COOKIE["token"])) {
                return true;
            }
        }
        return false;
    }

    public static function login()
    {
        $authService = AuthServiceImpl::getInstance();
        $isValid = $authService->verifyAgent($_POST["email"], $_POST["password"]);
        if ($isValid) {
            session_regenerate_id(true);
            $token = $authService->issueToken();
            $_SESSION["agentLogin"]["token"] = $token;
            if (isset($_POST["remember"])) {
                setcookie("token", $token, (new \DateTime('now'))->modify('+30 days')->getTimestamp(), "/", "", false, true);
            }
        }

        return $isValid;
    }

    public static function logout()
    {
        session_destroy();
        setcookie("token", "", time() - 3600, "/", "", false, true);
    }

    public static function register($view = null)
    {
        $agent = new Agent();
        $agent->setName($_POST["name"]);
        $agent->setEmail($_POST["email"]);
        $agent->setPassword($_POST["password"]);
        $agentValidator = new AgentValidator($agent);

        if ($agentValidator->isValid()) {
            if (AuthServiceImpl::getInstance()->editAgent($agent->getName(), $agent->getEmail(), $agent->getPassword())) {
                return true;
            } else {
                $agentValidator->setEmailError("Email already exists");
            }
        }

        $agent->setPassword("");
        AuthController::ShowRegisterView($agent, $agentValidator);
        return false;
    }

}