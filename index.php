<?php

require_once("Config/Autoloader.php");

use Access\DocumentAccess;
use Access\DocumentFieldAccess;
use Access\DocumentTypeAccess;
use Controller\AuthController;
use Controller\DashboardController;
use Controller\ErrorController;
use Controller\SettingsController;
use DTO\ReportEntry;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
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

    ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "You must login first."));
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
    if ($success) {
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

Router::route_auth("GET", "/settings", $authFunction, function () {
    SettingsController::Home();
});

// DOCUMENT TYPES

Router::route_auth("GET", "/settings/documenttypes", $authFunction, function () {
    DocumentTypeAccess::Home();
});

Router::route_auth("GET", "/settings/documenttypes/new", $authFunction, function () {
    DocumentTypeAccess::New();
});

Router::route_auth("GET", "/settings/documenttypes/edit", $authFunction, function () {
    DocumentTypeAccess::Edit();
});

Router::route_auth("POST", "/settings/documenttypes/save", $authFunction, function () {
    DocumentTypeAccess::Save();
});

Router::route_auth("GET", "/settings/documenttypes/delete", $authFunction, function () {
    DocumentTypeAccess::Delete();
});

Router::route_auth("POST", "/settings/documenttypes/delete", $authFunction, function () {
    DocumentTypeAccess::Delete();
});

// DOCUMENT FIELDS

Router::route_auth("GET", "/settings/documentfields", $authFunction, function () {
    DocumentFieldAccess::Home();
});

Router::route_auth("GET", "/settings/documentfields/new", $authFunction, function () {
    DocumentFieldAccess::New();
});

Router::route_auth("GET", "/settings/documentfields/edit", $authFunction, function () {
    DocumentFieldAccess::Edit();
});

Router::route_auth("POST", "/settings/documentfields/save", $authFunction, function () {
    DocumentFieldAccess::Save();
});

Router::route_auth("GET", "/settings/documentfields/delete", $authFunction, function () {
    DocumentFieldAccess::Delete();
});

Router::route_auth("POST", "/settings/documentfields/delete", $authFunction, function () {
    DocumentFieldAccess::Delete();
});


// DOCUMENTS
Router::route_auth("GET", "/documents", $authFunction, function () {
    DocumentAccess::Home();
});

Router::route_auth("GET", "/documents/new", $authFunction, function () {
    DocumentAccess::New();
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
