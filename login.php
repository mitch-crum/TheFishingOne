<?PHP
require_once( __DIR__ . "/include/rootFunc.php");
require_once( __DIR__ . "/include/user_manage/user_manage_config.php");
if (filter_has_var(INPUT_POST, "submitted")) {
    $userMan->getLoginFormData();
    if ($userMan->login()) {
        header("Location: success.php");
        exit;
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="reg.css">

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <script type="text/javascript" src="reg.js"></script>
    </head>
    <body>
        <div id="pageContainer">
            <div id="header">
                <div class="column" id="logo"><img src="res/img/logo.png" alt="WeFish" id="logoImg"></div>
            </div>
            <div id="columnContainer">
                <div class="column" id="leftColumn"></div>
                <div class="column" id="centerColumn">
                    <div class="RegBox">
                        <h2>Login</h2>
                        <div class="formDiv">
                            <!-- Form Entry -->
                            <form method="post" id="registration_form" action="<?php echo root::getSelf(); ?>">
                                <div>
                                <input type="hidden" name="submitted" id="submitted" value="1">
                                </div>
                                <fieldset>
                                    <legend>Login</legend>
                                    <div>
                                        <label for="username">Username: </label><br>
                                        <input type="text" name="username" id="username">
                                    </div>
                                    <div>
                                        <label for="password">Password</label><br>
                                        <input type="password" id="password" name="password">
                                    </div>
                                </fieldset>
                                <div class="submitBttnClass">
                                    <input type="submit" value="Submit">
                                </div>
                            </form>
                            <br>
                            <a href="registration.php">Don't have an account? Click here to Register</a>
                        </div>
                    </div>
                </div>
                <div class="column" id="rightColumn"></div>
            </div>
        </div>
    </body>
</html>