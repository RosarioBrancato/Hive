<div class="container">
    <h1>My First Bootstrap Page</h1>
    <form method="post" action="<?php echo $GLOBALS["ROOT_URL"]; ?>/login">
        <p>E-Mail<input type="text" name="email"/></p>
        <p>Password<input type="password" name="password"/></p>
        <p>Remember<input type="checkbox" name="remember" checked /></p>
        <p><input type="submit" value="Login"/></p>
    </form>
    <a href="/hive/register">Register</a>
</div>