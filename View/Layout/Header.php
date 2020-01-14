<?php

use Service\AuthServiceImpl;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/logo%20ppt.png">
    <title>Hive</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/navigation.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">

    <!--new from bootstrap studio-->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Bootstrap-Tags-Input.css">
    <link rel="stylesheet" href="assets/css/Drag--Drop-Upload-Form-1.css">
    <link rel="stylesheet" href="assets/css/Drag--Drop-Upload-Form.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/extensions/group-by-v2/bootstrap-table-group-by.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
    <link rel="stylesheet" href="assets/css/gridStyle.css">
</head>

<body id="page-top" class="sidebar-toggled">

<!-- SCRIPTS -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/chart.min.js"></script>
<script src="assets/js/bs-charts.js"></script>
<script src="assets/js/Bootstrap-Tags-Input-1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="https://cdn.anychart.com/js/8.0.1/anychart-core.min.js"></script>
<script src="https://cdn.anychart.com/js/8.0.1/anychart-pie.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/extensions/group-by-v2/bootstrap-table-group-by.min.js"></script>


<div id="wrapper">

    <?php if (AuthServiceImpl::getInstance()->getCurrentAgentId() > 0) { ?>
        <!-- NAVIGATION -->
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 toggled">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="<?php echo $GLOBALS["ROOT_URL"]; ?>">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fab fa-forumbee"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Hive</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo $GLOBALS["ROOT_URL"]; ?>"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo $GLOBALS["ROOT_URL"] . '/documents'; ?>"><i class="fas fa-table"></i><span>My Documents</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo $GLOBALS["ROOT_URL"] . '/documents/new'; ?>"><i class="fas fa-plus-square"></i><span>Add Document</span></a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes'; ?>"><i class="fas fa-gears"></i><span>Settings</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline">
                    <button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
                </div>
            </div>
        </nav>
    <?php } ?>
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">

            <?php if (AuthServiceImpl::getInstance()->getCurrentAgentId() > 0) { ?>
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid">
                        <button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <!-- place holder search bar -->
                            </div>
                        </form>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><!-- place holder search bar -->
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1" role="presentation">
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1" role="presentation">
                                <!-- place holder message icon -->
                            </li>
                            <li class="nav-item dropdown no-arrow" role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600"><?php echo AuthServiceImpl::getInstance()->getCurrentAgentName(); ?></span><i class="fa fa-align-justify"></i></a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu">
                                        <a href="<?php echo $GLOBALS["ROOT_URL"]; ?>" class="dropdown-item" role="presentation"><i class="fas fa-tachometer-alt fa-sm fa-fw mr-2 text-gray-400"></i>Dashboard</a>
                                        <a href="<?php echo $GLOBALS["ROOT_URL"] . '/documents'; ?>" class="dropdown-item" role="presentation"><i class="fas fa-table fa-sm fa-fw mr-2 text-gray-400"></i>My Documents</a>
                                        <a href="<?php echo $GLOBALS["ROOT_URL"] . '/documents/new'; ?>" class="dropdown-item" role="presentation"><i class="fas fa-plus-square fa-sm fa-fw mr-2 text-gray-400"></i>Add Documents</a>
                                        <a href="<?php echo $GLOBALS["ROOT_URL"] . '/settings/documenttypes'; ?>" class="dropdown-item" role="presentation"><i class="fas fa-gears fa-sm fa-fw mr-2 text-gray-400"></i>Settings</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="<?php echo $GLOBALS["ROOT_URL"]; ?>/logout" class="dropdown-item" role="presentation" onclick="return confirm('Do you really want to logout?')"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            <?php } ?>

