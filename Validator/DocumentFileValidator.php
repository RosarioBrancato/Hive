<?php


namespace Validator;


use DTO\DocumentFile;
use DTO\ReportEntry;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Util\FileUtils;

class DocumentFileValidator
{

    public function Validate(DocumentFile $documentFile)
    {
        $isValid = true;

        if (empty($documentFile->getFilename())) {
            $isValid = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, "File name invalid.");
        } else {
            $mime = FileUtils::GetMimeFromFilename($documentFile->getFilename());
            if (empty($mime)) {
                $isValid = false;
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "File type is not supported."));
            }
        }

        if (empty($documentFile->getPathToFile())) {
            $isValid = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, "File invalid.");
        } else if (filesize($documentFile->getPathToFile()) > 20000000) {
            $isValid = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, "File is too big. Maximum size is 20MB.");
        }

        return $isValid;
    }

}