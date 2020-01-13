<?php


namespace Test;


use Service\AuthServiceImpl;

class AuthServiceImplTest
{

    public function Execute()
    {
        //$this->TestAuthServiceImpl();
        $this->TestAuthToken();
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

    public function TestAuthToken() {
        $token = 'fc90833e42:e66cbb2cea744416218e1b3522937706f1f91cad';

        $success = AuthServiceImpl::getInstance()->validateToken($token);

        var_dump($success);
    }
}