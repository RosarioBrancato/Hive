<?php


namespace Controller;


use View\Layout\LayoutRendering;
use View\View;

class SettingsController
{

    public static function Home() {
        LayoutRendering::ShowView(new View('SettingsView.php'));
    }

}