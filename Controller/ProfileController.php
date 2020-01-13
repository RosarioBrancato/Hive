<?php
/**
 * Created by PhpStorm.
 * User: leeko
 * Date: 08/01/2020
 * Time: 23:53
 */

namespace Controller;

use DTO\Agent;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Model\AgentModel;
use Model\ProfileModel;
use Router\Router;
use Service\AuthServiceImpl;
use Validator\AgentValidator;
use View\Layout\LayoutRendering;
use View\View;

class ProfileController
{
    /** @var ProfileModel */
    private $model;

    /** @var int */
    private $agentId;


    public function __construct()
    {
        $this->agentId = AuthServiceImpl::getInstance()->getCurrentAgentId();
        $this->model = new ProfileModel($this->agentId);
    }


    public function ShowHomeView()
    {
        $agent = $this->model->get();

        $view = new View('ProfileView.php');
        $view->agent = $agent;
        $settingsMenu = new View('Layout/SettingsMenu.php');
        LayoutRendering::ShowView($view, $settingsMenu);
    }

    public function SaveAttributes(Agent $agent)
    {
        $validator = new AgentValidator();
        $isOk = $validator->validateAttributes($agent);

        if ($isOk) {
            $agentCheck = $this->model->get();

            //check if e-mail is unique
            $agentModel = new AgentModel();
            if($agent->getEmail() === $agentCheck->email) {
                $isOk = true;

            } else if (is_null($agentModel->findByEmail($agent->getEmail()))) {
                $isOk = true;

            } else {
                $isOk = false;
                ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, "New e-mail is not available");
            }
        }

        if ($isOk) {
            $isOk = $this->model->update($agent);

            if (!$isOk) {
                ReportHelper::AddEntryArgs(ReportEntryLevel::Error, "Error occured");
            }
        }

        if ($isOk) {
            ReportHelper::AddEntryArgs(ReportEntryLevel::Success, "Profile updated");
        }

        Router::redirect("/profile");
    }

    public function SavePassword($passwords)
    {
        $isOk = true;

        if (empty($passwords["new_pw"]) || empty($passwords["verify_pw"]) || empty($passwords["current_pw"])) {
            $isOk = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, "Any password may not be empty");

        } else if ($passwords["new_pw"] !== $passwords["verify_pw"]) {
            $isOk = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, "New password and verify password are not equal");
        }

        if ($isOk) {
            $agentModel = new AgentModel();
            $agent = $agentModel->read($this->agentId);

            if (password_verify($passwords["current_pw"], $agent->getPassword())) {
                $agent->setPassword(password_hash($passwords["new_pw"], PASSWORD_DEFAULT));
                $agentNew = $agentModel->update($agent);

                $isOk = ($agentNew->getPassword() === $agent->getPassword());
                if (!$isOk) {
                    ReportHelper::AddEntryArgs(ReportEntryLevel::Error, "Error occured");
                }

            } else {
                $isOk = false;
                ReportHelper::AddEntryArgs(ReportEntryLevel::Error, "Current password not correct");
            }
        }

        if ($isOk) {
            ReportHelper::AddEntryArgs(ReportEntryLevel::Success, "Password updated");
        }
        Router::redirect("/profile");
    }

    public function Delete()
    {
        $isOk = $this->model->delete();

        if ($isOk) {
            AuthController::logout();
            ReportHelper::AddEntryArgs(ReportEntryLevel::Success, "Profile deleted");
        } else {
            ReportHelper::AddEntryArgs(ReportEntryLevel::Success, "Error occured");
        }
        Router::redirect("/login");
    }
}