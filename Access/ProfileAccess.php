<?php
/**
 * Created by PhpStorm.
 * User: leeko
 * Date: 11/01/2020
 * Time: 14:40
 */

namespace Access;


use Controller\ProfileController;
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

    public static function Save()
    {
        if (!isset($_GET["username"], $_GET["email"])) {
            if (!isset($_GET["username"])) {
                ReportHelper::AddEntryArgs(ReportEntryLevel::Error, "Invalid username");
            }
            if (!isset($_GET["email"])) {
                ReportHelper::AddEntryArgs(ReportEntryLevel::Error, "Invalid e-mail");
            }
            Router::redirect("/profile");
        }
    }
}