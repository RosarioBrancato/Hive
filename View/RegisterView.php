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
<div class="container">
    <h1>Register</h1>
    <form method="post" action="<?php echo $GLOBALS["ROOT_URL"]; ?>/register">
        <p>Name<input type="text" name="name" value="<?php echo $this->agent->getName(); ?>" /><?php echo $this->agentValidator->getNameError(); ?></p>
        <p>E-Mail<input type="text" name="email" value="<?php echo $this->agent->getEmail(); ?>" /><?php echo $this->agentValidator->getEmailError(); ?></p>
        <p>Password<input type="password" name="password" /><?php echo $this->agentValidator->getPasswordError(); ?></p>
        <p><input type="submit" value="Register"/></p>
    </form>
</div>