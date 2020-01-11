<?php


namespace Test;


use Model\ProfileModel;

class AgentTest
{
    public function Execute()
    {
        $this->TestAgentModel();
    }

    private function TestAgentModel()
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
}