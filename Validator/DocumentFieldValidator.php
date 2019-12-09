<?php


namespace Validator;


use DTO\DocumentField;
use DTO\ReportEntry;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Model\DocumentFieldModel;

class DocumentFieldValidator
{
    private $model;

    public function __construct(DocumentFieldModel $model)
    {
        $this->model = $model;
    }

    public function Validate(DocumentField $documentField): bool
    {
        $isValid = true;

        if (empty($documentField->getLabel())) {
            $isValid = false;
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Label cannot be empty."));

        } else {
            $isUnique = $this->model->isLabelUnique($documentField->getLabel(), $documentField->getId());
            if (!$isUnique) {
                $isValid = false;
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "A document field labeled '" . $documentField->getLabel() . "' already exists"));
            }
        }

        if($documentField->getFieldType() < 0) {
            $isValid = false;
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Field type cannot be empty."));
        }

        if(empty($documentField->getDocumentTypeId())) {
            $isValid = false;
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document type cannot be empty."));
        }

        if (!empty($documentField->getId())) {
            $agentOk = $this->model->checkAgentId($documentField->getId());
            if(!$agentOk) {
                $isValid = false;
                ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Error, "User data could not be loaded. Please relog."));
            }
        }

        return $isValid;
    }

}