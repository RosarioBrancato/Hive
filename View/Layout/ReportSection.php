<?php

use Enumeration\Constant;
use Enumeration\ReportEntryLevel;

if (isset($_SESSION[Constant::SessionReport])) {
    $report = $_SESSION[Constant::SessionReport];

    foreach ($report as $entry) {
        $alertType = "alert-info";

        switch ($entry->getLevel()) {
            case ReportEntryLevel::Success:
                $alertType = "alert-success";
                break;
            case ReportEntryLevel::Warning:
                $alertType = "alert-warning";
                break;
            case ReportEntryLevel::Error:
                $alertType = "alert-danger";
                break;
        }

        ?>
        <div class="container">
            <div class="alert <?php echo $alertType; ?>" role="alert">
                <?php echo $entry->getMessage(); ?>
            </div>
        </div>
        <?php
    }

    $_SESSION[Constant::SessionReport] = array();
}
?>

