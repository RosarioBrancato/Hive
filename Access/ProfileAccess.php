<?php
/**
 * Created by PhpStorm.
 * User: leeko
 * Date: 11/01/2020
 * Time: 14:40
 */

namespace Access;


use Controller\ProfileController;
use DTO\Agent;
use Enumeration\ReportEntryLevel;
use Router\Router;
use Helper\ReportHelper;


class ProfileAccess
{

    public static function Home()
    {
        $controller = new ProfileController();
        $controller->ShowHomeView();
    }

    public static function SaveAttributes()
    {
        if (!isset($_POST["username"], $_POST["email"], $_POST["timezone"])) {
            if (!isset($_POST["username"])) {
                ReportHelper::AddEntryArgs(ReportEntryLevel::Error, "Invalid username");
            }
            if (!isset($_POST["email"])) {
                ReportHelper::AddEntryArgs(ReportEntryLevel::Error, "Invalid e-mail");
            }
            if (!isset($_POST["timezone"])) {
                ReportHelper::AddEntryArgs(ReportEntryLevel::Error, "Invalid timezone");
            }
            Router::redirect("/profile");
        }

        $agent = new Agent();
        $agent->setName($_POST["username"]);
        $agent->setEmail($_POST["email"]);
        $agent->setTimezone($_POST["timezone"]);

        $controller = new ProfileController();
        $controller->SaveAttributes($agent);
    }

    public static function SavePassword()
    {
        if (!isset($_POST["current_password"], $_POST["new_password"], $_POST["verify_password"])) {
            if (!isset($_POST["current_password"])) {
                ReportHelper::AddEntryArgs(ReportEntryLevel::Error, "Invalid password");
            }
            if (!isset($_POST["new_password"])) {
                ReportHelper::AddEntryArgs(ReportEntryLevel::Error, "Invalid password");
            }
            if (!isset($_POST["verify_password"])) {
                ReportHelper::AddEntryArgs(ReportEntryLevel::Error, "Invalid password");
            }
            Router::redirect("/profile");
        }

        $passwords = [
            "current_pw" => $_POST["current_password"],
            "new_pw" => $_POST["new_password"],
            "verify_pw" => $_POST["verify_password"]
        ];

        //var_dump($passwords);

        $controller = new ProfileController();
        $controller->SavePassword($passwords);
    }

    public static function Delete()
    {
        $controller = new ProfileController();
        $controller->Delete();
    }
}