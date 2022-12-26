<!-- this is the Simple sexy PHP Login Script. You can find it on http://www.php-login.net ! It's free and open source. -->

<!-- errors & messages --->

<?php

// show negative messages
if ($login->errors) {
    foreach ($login->errors as $error) {
        echo $error;    
    }
}

// show positive messages
if ($login->messages) {
    foreach ($login->messages as $message) {
        echo $message;
    }
}

?>             

<!-- login form box -->
<form method="post" action="index.php" name="loginform">
    <label for="login_input_username">Username</label><br/>
    <input id="login_input_username" class="login_input" type="text" name="user_name" required /><br/><br/>
    <label for="login_input_password">Password</label><br/>
    <input id="login_input_password" class="login_input" type="password" name="user_password" autocomplete="off" required /><br/><br/>
    <input type="checkbox" id="login_input_rememberme" name="user_rememberme" value="1" /> Keep me logged in (for 2 weeks)<br/><br/>
    <input type="submit"  name="login" value="Log in" /><br/><br/>
</form>

<a href="register.php">Register new account</a>
<a href="password_reset.php">I forgot my password</a>

<!-- this is the Simple sexy PHP Login Script. You can find it on http://www.php-login.net ! It's free and open source. -->
