<?php

use Test\AgentTest;
use Test\AuthServiceImplTest;
use Test\DocumentFieldTest;
use Test\DocumentTypeTest;

require_once("Config/Autoloader.php");


ini_set('session.cookie_httponly', 1);
session_start();


// CALL TESTS
//(new AgentTest())->Execute();
//(new AuthServiceImplTest())->Execute();
//(new DocumentTypeTest())->Execute();
(new DocumentFieldTest())->Execute();

