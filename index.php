<?php

require_once("Config/Autoloader.php");

use Controller\AuthController;
use Controller\DashboardController;
use Controller\ErrorController;
use Http\HTTPHeader;
use Http\HTTPStatusCode;
use Http\HTTPException;
use Router\Router;


ini_set('session.cookie_httponly', 1);
session_start();

$authFunction = function () {
    if (AuthController::authenticate()) {
        return true;
    }
    Router::redirect("/login");
    return false;
};

Router::route("GET", "/login", function () {
    if (!AuthController::authenticate()) {
        AuthController::ShowLoginView();
    } else {
        Router::redirect("/");
    }
});

Router::route("POST", "/login", function () {
    if (!AuthController::authenticate()) {
        AuthController::login();
    }
    Router::redirect("/");
});

Router::route("GET", "/register", function () {
    if (!AuthController::authenticate()) {
        AuthController::ShowRegisterView();
    } else {
        Router::redirect("/");
    }
});

Router::route("POST", "/register", function () {
    $success = true;
    if (!AuthController::authenticate()) {
        $success = AuthController::register();
    }
    if($success) {
        Router::redirect("/login");
    }
});

Router::route_auth("GET", "/", $authFunction, function () {
    DashboardController::Home();
});

Router::route_auth("GET", "/logout", $authFunction, function () {
    AuthController::logout();
    Router::redirect("/login");
});

try {
    HTTPHeader::setHeader("Access-Control-Allow-Origin: *");
    HTTPHeader::setHeader("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD");
    HTTPHeader::setHeader("Access-Control-Allow-Headers: Authorization, Location, Origin, Content-Type, X-Requested-With");
    if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
        HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
    } else {
        Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);
    }
} catch (HTTPException $exception) {
    $exception->getHeader();
    ErrorController::show404();
}
