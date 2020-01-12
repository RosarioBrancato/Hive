<?php

use DTO\Agent;
use Validator\AgentValidator;

if(!isset($this->agent)) {
    $this->agent = new Agent();
}
if(!isset($this->agentValidator)) {
    $this->agentValidator = new AgentValidator();
}

?>
<!--
<div class="container">
    <h1>Register</h1>
    <form method="post" action="<?php echo $GLOBALS["ROOT_URL"]; ?>/register">
        <p>Name<input type="text" name="name" value="<?php echo $this->agent->getName(); ?>" /><?php echo $this->agentValidator->getNameError(); ?></p>
        <p>E-Mail<input type="text" name="email" value="<?php echo $this->agent->getEmail(); ?>" /><?php echo $this->agentValidator->getEmailError(); ?></p>
        <p>Password<input type="password" name="password" /><?php echo $this->agentValidator->getPasswordError(); ?></p>
        <p><input type="submit" value="Register"/></p>
    </form>
</div>
-->

<div class="container">
    <div class="card shadow-lg o-hidden border-0 my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-flex">
                    <div class="flex-grow-1 bg-register-image" style="background-image: url(&quot;assets/img/bees/bee%20butt%20orange.jpg&quot;);"></div>
                </div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h4 class="text-dark mb-4">Create an Account! Bee a part of Hive!</h4>
                        </div>
                        <form class="user" method="post" action="<?php echo $GLOBALS["ROOT_URL"]; ?>/register">
                            <div class="form-group"><input class="form-control form-control-user" type="text" placeholder="Username" name="name" value="<?php echo $this->agent->getName(); ?>" /><?php echo $this->agentValidator->getNameError(); ?></div>
                            <div class="form-group"><input class="form-control form-control-user" type="email" aria-describedby="emailHelp" placeholder="Email Address" name="email" value="<?php echo $this->agent->getEmail(); ?>" /><?php echo $this->agentValidator->getEmailError(); ?></div>
                            <div class="form-group"><input class="form-control form-control-user" type="password" placeholder="Password" name="password" /><?php echo $this->agentValidator->getPasswordError(); ?></div>
                            <button class="btn btn-primary btn-block text-white btn-user" type="submit" value="Register"/>Register Account</button>
                            <hr>
                        </form>
                        <div class="text-center"></div>
                        <div class="text-center"><a class="small" href="<?php echo $GLOBALS["ROOT_URL"] . '/login'; ?>">Already have an account? Login!</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>