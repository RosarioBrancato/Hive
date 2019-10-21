<?php


namespace Controller;


use View\Layout\LayoutRendering;
use View\View;

class DashboardController
{

    public static function Home() {
        LayoutRendering::ShowView(new View('DashboardHome.php'));
    }

}