<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 09.10.2017
 * Time: 08:30
 */

namespace Controller;

use DTO\Agent;
use DTO\ReportEntry;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
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
        $agent = $authService->verifyAgent($_POST["email"], $_POST["password"]);
        $isValid = isset($agent);
        if ($isValid) {
            session_regenerate_id(true);

            //set token
            $token = $authService->issueToken();
            $_SESSION["agentLogin"]["token"] = $token;
            if (isset($_POST["remember"])) {
                setcookie("HIVE-TOKEN", $token, (new \DateTime('now'))->modify('+30 days')->getTimestamp(), "/", "", false, true);
            }

            //set agent
            $agent->setPassword("");
            $_SESSION["agentLogin"]["agent"] = $agent;

            //set report
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, "Login successful!"));
        } else {
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "Login failed."));
        }

        return $isValid;
    }

    public static function logout()
    {
        session_destroy();
        setcookie("HIVE-TOKEN", "", time() - 3600, "/", "", false, true);
        AuthServiceImpl::getInstance()->destroySession();
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
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Success, "Registration successful!"));
                return true;
            } else {
                $agentValidator->setEmailError("Email already exists");
            }
        }

        ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "Registration failed."));
        $agent->setPassword("");
        AuthController::ShowRegisterView($agent, $agentValidator);
        return false;
    }

}