<?php

require_once("config/Autoloader.php");

use Controller\ErrorController;
use Controller\LoginController;
use Http\HTTPHeader;
use Http\HTTPStatusCode;
use Http\HTTPException;
use Router\Router;


ini_set('session.cookie_httponly', 1);
session_start();

Router::route_auth("GET", "/", null, function () {
    LoginController::Index();
});

Router::route("POST", "/login", function () {
    LoginController::Login();
});

Router::route("GET", "/logout", function () {
    LoginController::Logout();
    Router::redirect("/");
});

Router::route("GET", "/test", function () {
    LoginController::Index();
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
