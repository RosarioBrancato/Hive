<?php


namespace Access;


use Controller\DocumentController;
use DTO\Document;

class DocumentAccess
{

    public static function Home()
    {
        $controller = new DocumentController();
        $controller->ShowHomePage();
    }

    public static function New()
    {
        $document = new Document();

        $controller = new DocumentController();
        $controller->ShowNewForm($document);
    }

}