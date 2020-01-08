<?php


namespace Validator;


use DTO\DocumentFile;
use DTO\ReportEntry;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;

class DocumentFileValidator
{

    public function Validate(DocumentFile $documentFile)
    {
        $isValid = true;

        if (empty($documentFile->getFilename())) {
            $isValid = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, "File name invalid.");
        }

        if (empty($documentFile->getPathToFile())) {
            $isValid = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, "File invalid.");
        }

        return $isValid;
    }

}