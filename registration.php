<?PHP
require_once( __DIR__ . "/include/rootFunc.php");
require_once( __DIR__ . "/include/user_manage/user_manage_config.php");

// If Form Submitted
if (filter_has_var(INPUT_POST, "submitted")) {
    $userMan->getRegFormData();
    $userMan->regFormsValidate();
    if ($userMan->regFormIsValid()) {
        $userMan->DB_addUser();
    }
}

// Echo Error Class Selectors
function echoErrorClass($ids) {
    global $userMan;
    $doIt = true;
    reset($ids);
    if (filter_has_var(INPUT_POST, "submitted")) {
        foreach ($ids as $val) {
            if (!$userMan->regFormIsValid($val)) {
                $doIt = false;
            }
        }
    }
    echo $doIt ? "normal" : "error";
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
        <title>Register</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="reg.css">

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript">
            var Selections = {
                month: "<?php $userMan->regFormSafeDisplace("month"); ?>",
                state: "<?php $userMan->regFormSafeDisplace("state"); ?>",
                country: "<?php $userMan->regFormSafeDisplace("country"); ?>"
            };
        </script>
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
                        <h2>Register</h2>
                        <div class="error">
                            <?PHP
                            $userMan->echoRegFormErrors();
                            ?>
                        </div>
                        <br>
                        <div class="formDiv">
                            <!-- Form Entry -->
                            <form method="post" id="registration_form" action="<?php echo root::getSelf(); ?>">
                                <div>
                                    * required fields<br>
                                    <input type="hidden" name="submitted" id="submitted" value="1">
                                </div>
                                <!-- Name -->
                                <fieldset>
                                    <legend class="<?php echoErrorClass(array("first", "last")); ?>">Name*</legend>
                                    <div>
                                        <label for="first" class="<?php echoErrorClass(array("first")); ?>">First*: </label><br>
                                        <input type="text" name="first" id="first" value="<?php $userMan->regFormSafeDisplace("first"); ?>">
                                    </div>
                                    <div>
                                        <label for="last" class="<?php echoErrorClass(array("last")); ?>">Last*: </label><br>
                                        <input type="text" id="last" name="last" value="<?php $userMan->regFormSafeDisplace("last"); ?>">
                                    </div>
                                </fieldset>
                                <!-- Gender -->
                                <fieldset>
                                    <legend class="<?php echoErrorClass(array("gender")); ?>">Gender*</legend>
                                    <div class="<?php echoErrorClass(array("gender")); ?>">
                                        <label for="male">Male </label>
                                        <input type="radio" name="gender" id="male" value="male"<?php
                                        if (root::frmtPost("gender") == "male") {
                                            echo " checked=\"checked\"";
                                        }
                                        ?>><br>
                                        <label for="female">Female </label>
                                        <input type="radio" name="gender" id="female" value="female"<?php
                                        if (root::frmtPost("gender") == "female") {
                                            echo " checked=\"checked\"";
                                        }
                                        ?>><br>
                                        <label for="other">Other </label>
                                        <input type="radio" name="gender" id="other" value="other"<?php
                                        if (root::frmtPost("gender") == "other") {
                                            echo " checked=\"checked\"";
                                        }
                                        ?>><br>
                                    </div>
                                </fieldset>
                                <!-- Date of Birth -->
                                <fieldset>
                                    <legend class="<?php echoErrorClass(array("month", "year")); ?>">Date of Birth*</legend>
                                    <div>
                                        <label for="monthSelector" class="<?php echoErrorClass(array("month")); ?>">Month*:</label><br>
                                        <select name="month" id="monthSelector">
                                            <option value="">Select a Month</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="year" class="<?php echoErrorClass(array("year")); ?>">Year*:</label><br>
                                        <input type="text" name="year" id="year" value="<?php $userMan->regFormSafeDisplace("year"); ?>">
                                    </div>
                                </fieldset>
                                <!-- Phone -->
                                <fieldset>
                                    <legend class="<?php echoErrorClass(array("phone1")); ?>">Phone Number*</legend>
                                    <div>
                                        <label for="phone1" class="<?php echoErrorClass(array("phone1")); ?>">Primary Phone*:</label><br>
                                        <input type="text" id="phone1" name="phone1" value="<?php $userMan->regFormSafeDisplace("phone1"); ?>">
                                    </div>
                                    <div>
                                        <label for="phone2" class="<?php echoErrorClass(array("phone2")); ?>">Secondary Phone*:</label><br>
                                        <input type="text" id="phone2" name="phone2" value="<?php $userMan->regFormSafeDisplace("phone2"); ?>">
                                    </div>
                                </fieldset>
                                <!-- Address -->
                                <fieldset>
                                    <legend class="<?php echoErrorClass(array("line1", "line2", "city", "country", "state", "zip")); ?>">Address*</legend>
                                    <div>
                                        <label for="line1" class="<?php echoErrorClass(array("line1")) ?>">Street Address*:</label><br>
                                        <input type="text" id="line1" name="line1" value="<?php $userMan->regFormSafeDisplace("line1"); ?>">
                                    </div>
                                    <div>
                                        <label for="line2" class="<?php echoErrorClass(array("line2")) ?>">Line 2:</label><br>
                                        <input type="text" id="line2" name="line2" value="<?php $userMan->regFormSafeDisplace("line2"); ?>">
                                    </div>
                                    <div>
                                        <label for="city" class="<?php echoErrorClass(array("city")) ?>">City*:</label><br>
                                        <input type="text" id="city" name="city" value="<?php $userMan->regFormSafeDisplace("city"); ?>">
                                    </div>
                                    <div>
                                        <label for="countrySelector" class="<?php echoErrorClass(array("country")) ?>">Country*:</label><br>
                                        <select name="country" id="countrySelector">
                                            <option value="">Select a Country</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="stateSelector" class="<?php echoErrorClass(array("state")) ?>">State*:</label><br>
                                        <select name="state" id="stateSelector">
                                            <option value="">Select a State</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="zip" class="<?php echoErrorClass(array("zip")) ?>">Zipcode*:</label><br>
                                        <input type="text" id="zip" name="zip" value="<?php $userMan->regFormSafeDisplace("zip"); ?>">
                                    </div>
                                </fieldset>
                                <!-- Email -->
                                <fieldset>
                                    <legend class="<?php echoErrorClass(array("email1", "email2")); ?>">Email*</legend>
                                    <div>
                                        <label for="email1" class="<?php echoErrorClass(array("email1")) ?>">Email*:</label><br>
                                        <input type="text" id="email1" name="email1" value="<?php $userMan->regFormSafeDisplace("email1"); ?>">
                                    </div>
                                    <div>
                                        <label for="email2" class="<?php echoErrorClass(array("email2")) ?>">Verify Email*:</label><br>
                                        <input type="text" id="email2" name="email2" value="<?php $userMan->regFormSafeDisplace("email2"); ?>">
                                    </div>
                                    <br>
                                </fieldset>

                                <fieldset>
                                    <legend class="<?php echoErrorClass(array("username", "password1", "password2")); ?>">User*</legend>
                                    <div>
                                        <label for="username" class="<?php echoErrorClass(array("username")) ?>">Username*:</label><br>
                                        <input type="text" id="username" name="username" value="<?php $userMan->regFormSafeDisplace("username"); ?>">                            
                                    </div>
                                    <div>
                                        <label for="password1" class="<?php echoErrorClass(array("password1")) ?>">Password*:</label><br>
                                        <input type="password" id="password1" name="password1">
                                    </div>
                                    <div>
                                        <label for="password2" class="<?php echoErrorClass(array("password2")) ?>">Verify Password*:</label><br>
                                        <input type="password" id="password2" name="password2">
                                    </div>
                                </fieldset>
                                <div class="submitBttnClass">
                                    <input type="submit" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div></div>
                <div class="column" id="rightColumn"></div>
            </div>
        </div>
    </body>
</html>
