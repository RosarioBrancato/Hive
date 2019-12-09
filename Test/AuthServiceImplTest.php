<?php


namespace Test;


use Service\AuthServiceImpl;

class AuthServiceImplTest
{

    public function Execute()
    {
        $this->TestAuthServiceImpl();
    }

    public function TestAuthServiceImpl()
    {
        $instance = AuthServiceImpl::getInstance();

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