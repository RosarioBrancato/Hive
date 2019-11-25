<?php

require_once("Config/Autoloader.php");


ini_set('session.cookie_httponly', 1);
session_start();


class UnitTests
{
    public function TestAgentModel()
    {
        echo "<p>findByEmail</p>";
        $model = new \Model\AgentModel();
        $agentEmail = $model->findByEmail("test@test.ch");
        var_dump($agentEmail);

        echo "<p>read</p>";
        $agentById = $model->read(1);
        var_dump($agentById);

        echo "<p>create</p>";
        $agentIn = new \DTO\Agent();
        $agentIn->setName("Rosario");
        $agentIn->setEmail("rosario@test.ch");
        $agentIn->setPassword("1234");
        var_dump($agentIn);
        $agentOut = $model->create($agentIn);
        var_dump($agentOut);
    }

    public function TestAuthServiceImpl()
    {
        $instance = \Service\AuthServiceImpl::getInstance();

        echo "<p>issueToken</p>";
        $isOk = $instance->verifyAgent("test@test.ch", "5678");
        var_dump($isOk);

        echo "<p>current agent</p>";
        $agent = $instance->getCurrentAgentId();
        var_dump($agent);

        echo "<p>issueToken agent</p>";
        $tokenAgent = $instance->issueToken();
        var_dump($tokenAgent);

        echo "<p>issueToken reset</p>";
        $tokenReset = $instance->issueToken(\Service\AuthServiceImpl::RESET_TOKEN, "test@test.ch");
        var_dump($tokenReset);
    }

    public function TestModel() {
        $model = new \Model\DocumentTypeModel(1);


        $isUnique = $model->isNameUnique("invoice", 1);
        var_dump($isUnique);

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

        echo "<p>insert</p>";
        $documentType = new \DTO\DocumentType();
        $documentType->setName("unit test insert V2");
        $documentType->setAgentId(4);
        echo $model->add($documentType);
        var_dump($documentType);


        echo "<p>update</p>";
        $dto->setName($dto->getName() . " EDITED");
        echo $model->edit($dto);


        echo "<p>delete</p>";
        echo $model->delete(6, 4);
        */

    }
}

echo "<h1>TEST</h1>";
$unitTests = new UnitTests();
//$unitTests->TestAgentModel();
//$unitTests->TestAuthServiceImpl();
$unitTests->TestModel();
