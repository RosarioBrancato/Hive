<?php

namespace Helper;

use DTO\ReportEntry;
use Enumeration\Constant;
use Enumeration\ReportEntryLevel;

class ReportHelper
{

    public static function AddEntry(ReportEntry $reportEntry)
    {
        if (isset($reportEntry)) {
            if (!isset($_SESSION[Constant::SessionReport])) {
                $_SESSION[Constant::SessionReport] = array();
            }

            array_push($_SESSION[Constant::SessionReport], $reportEntry);
        }
    }

    public static function AddEntryArgs(int $level, string $message) {
        ReportHelper::AddEntry(new ReportEntry($level, $message));
    }

}