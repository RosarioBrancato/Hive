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
}

echo "<h1>TEST</h1>";
$unitTests = new UnitTests();
//$unitTests->TestAgentModel();
//$unitTests->TestAuthServiceImpl();
