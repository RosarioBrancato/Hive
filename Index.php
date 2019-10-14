<?php

require_once("config/Autoloader.php");

use Controller\LoginController;

$GLOBALS["ROOT_URL"] = "/hive/";

if (isset($_POST['username'])) {
    LoginController::Login();
} else {
    LoginController::Index();
}
