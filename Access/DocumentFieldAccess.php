<?php


namespace Access;


use Controller\DocumentFieldController;

class DocumentFieldAccess
{

    public static function Home() {
        $controller = new DocumentFieldController();
        $controller->ShowHomePage();
    }

}