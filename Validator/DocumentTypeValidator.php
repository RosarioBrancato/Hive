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

        if (!empty($documentType->getId())) {
            $agentOk = $this->model->checkAgentId($documentType->getId());
            if(!$agentOk) {
                $isValid = false;
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "User data could not be loaded. Please relog."));
            }
        }

        return $isValid;
    }

}