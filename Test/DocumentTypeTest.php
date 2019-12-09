<?php


namespace Test;


use \Model\DocumentTypeModel;

class DocumentTypeTest
{
    private $model = null;

    public function Execute()
    {
        $agentId = 1;
        $this->model = new DocumentTypeModel($agentId);

        $this->TestIsUnique("invoice", 1);
    }

    private function TestIsUnique(string $label, int $exceptId)
    {
        $isUnique = $this->model->isNameUnique($label, $exceptId);
        var_dump($isUnique);
    }

    private function TestModel()
    {
        $model = new \Model\DocumentTypeModel(1);


        /*$isUnique = $model->isNameUnique("invoice", 1);
        var_dump($isUnique);*/

        /*$documentType = new \DTO\DocumentType();
        $documentType->setId(1);;
        $documentType->setAgentId(1);
        $documentType->setNumber(1);
        $documentType->setName("invoice");
        $model->edit($documentType);*/

        /* echo "<p>get all</p>";
         var_dump($model->getAll());*/

        /*
        echo "<p>get</p>";
        $dto = $model->get(2, 4);
        var_dump($dto);
        */

        /*
        echo "<p>insert</p>";
        $documentType = new \DTO\DocumentType();
        $documentType->setNumber(99);
        $documentType->setName("unit test insert V2");
        $documentType->setAgentId(1);
        echo $model->add($documentType);
        var_dump($documentType);
        */

        /*
        echo "<p>update</p>";
        $dto->setName($dto->getName() . " EDITED");
        echo $model->edit($dto);


        echo "<p>delete</p>";
        echo $model->delete(6, 4);
        */


        $documentType = new \DTO\DocumentType();
        //$documentType->setId(12);
        $documentType->setId(null);
        $documentType->setNumber(6);
        $documentType->setName("general");
        $documentType->setAgentId(1);
        var_dump($documentType);

        echo "<p>validate</p>";
        $isUnique = $model->isNameUnique($documentType->getName(), $documentType->getId());
        var_dump($isUnique);

        $validator = new \Validator\DocumentTypeValidator($model);
        $isValid = $validator->Validate($documentType);
        var_dump($isValid);


    }
}
