<?php


namespace Validator;


use DTO\DocumentFieldValue;
use Enumeration\FieldType;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;

class DocumentFieldValueValidator
{

    public function Validate(DocumentFieldValue $documentFieldValue)
    {
        $isValid = true;

        if (empty($documentFieldValue->getNumber())) {
            $isValid = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, "Custom field order not set.");
        }

        if (empty($documentFieldValue->getLabel())) {
            $isValid = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, "Custom field not recognized.");
        }

        if (is_null($documentFieldValue->getFieldType())) {
            $isValid = false;
            ReportHelper::AddEntryArgs(ReportEntryLevel::Warning, "Custom field type not found.");
        }

        return $isValid;
    }

}