<?php


namespace Validator;


use DTO\DocumentType;
use DTO\ReportEntry;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Model\DocumentTypeModel;

class DocumentTypeValidator
{
    private $model;

    public function __construct(DocumentTypeModel $model)
    {
        $this->model = $model;
    }

    public function Validate(DocumentType $documentType)
    {
        $isValid = true;

        if (empty($documentType->getName())) {
            $isValid = false;
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Name cannot be empty."));

        } else {
            $isUnique = $this->model->isNameUnique($documentType->getName(), $documentType->getId());
            if (!$isUnique) {
                $isValid = false;
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "A document type named '" . $documentType->getName() . "' already exists"));
            }
        }

        return $isValid;
    }

}