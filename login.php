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
        <link rel="stylesheet" type="text/css" href="reg.css">

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="formDiv">
            <!-- Form Entry -->
            <form method="post" id="registration_form" action="<?php echo root::getSelf(); ?>">
                <input type="hidden" name="submitted" id="submitted" value="1">
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
                <br>
                <div class="submitBttnClass">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
    </body>
</html>
