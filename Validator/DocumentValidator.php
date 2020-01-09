<?php


namespace Validator;


use DTO\Document;
use DTO\ReportEntry;
use Enumeration\ReportEntryLevel;
use Helper\ReportHelper;
use Model\DocumentModel;
use Util\FileUtils;

class DocumentValidator
{
    /** @var DocumentModel */
    private $model;

    public function __construct(DocumentModel $model)
    {
        $this->model = $model;
    }

    public function Validate(Document $document)
    {
        $isValid = true;

        if (empty($document->getTitle())) {
            $isValid = false;
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Title cannot be empty."));
        }

        if (empty($document->getDocumenttypeid())) {
            $isValid = false;
            ReportHelper::AddEntry(new ReportEntry(ReportEntryLevel::Warning, "Document type cannot be empty."));
        }


        return $isValid;
    }

}