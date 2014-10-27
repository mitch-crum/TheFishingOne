<?PHP
require_once( __DIR__ . "/include/rootFunc.php");
require_once( __DIR__ . "/include/user_manage/user_manage_config.php");
?>
<?PHP
// form data vars
$first = $last = $gender = $month = $year = $phone1 = $phone2 = $line1 = $line2 = $city = "";
$country = $state = $zip = $email1 = $email2 = $username = $password1 = $password2 = "";

// "is empty" array
$isEmpty = array("first" => false, "last" => false, "gender" => false, "gender" => false, "month" => false, "year" => false, "phone1" => false,
    "phone2" => false, "line1" => false, "line2" => false, "city" => false, "state" => false, "country" => false, "zip" => false, "email1" => false,
    "email2" => false, "username" => false, "password1" => false, "password2" => false);

// bools
$formSubmitted = $isUS = $missingRequired = false;

// fix input
function fix_input($data) {
    return htmlspecialchars(stripcslashes(trim($data)));
}

// parse form input
function parse_form_input($id) {
    global $missingRequired, $country, $isEmpty;
    $isEmpty[$id] = empty($_POST[$id]);
    $data = "";
    if (!$isEmpty[$id]) {
        $data = fix_input($_POST[$id]);
    } else {
        switch ($id) {
            case "state":
                if ($country == "US") {
                    $missingRequired = true;
                }
                break;
            case "phone2":
                break;
            case "line2":
                break;
            default:
                $missingRequired = true;
                break;
        }
    }
    return $data;
}

// echo previous form data
function echo_preivious($id) {
    if (isset($_POST[$id])) {
        echo fix_input($_POST[$id]);
    }
}

// Has a form been submitted ?
$formSubmitted = ( $_SERVER["REQUEST_METHOD"] == "POST");

// Parse Form Data if it has been submitted
if ($formSubmitted) {
    $first = parse_form_input("first");
    $last = parse_form_input("last");

    $gender = parse_form_input("gender");

    $month = parse_form_input("month");
    $year = parse_form_input("year");

    $phone1 = parse_form_input("phone1");
    $phone2 = parse_form_input("phone2");

    $line1 = parse_form_input("line1");
    $line2 = parse_form_input("line2");
    $city = parse_form_input("city");
    $country = parse_form_input("country");
    $isUS = ( $country == "US");
    $state = parse_form_input("state");
    $zipcode = parse_form_input("zip");

    $email1 = parse_form_input("email1");
    $email2 = parse_form_input("email2");

    $username = parse_form_input("username");
    $password1 = parse_form_input("password1");
    $password2 = parse_form_input("password2");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="reg.css">

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript">
            var Selections = {
                month: "<?php root::echoPost("month"); ?>",
                state: "<?php root::echoPost("state"); ?>",
                country: "<?php root::echoPost("country"); ?>"
            }
        </script>
        <script type="text/javascript" src="reg.js"></script>
    </head>
    <body>
        <div class="formDiv">
            <!-- Form Entry -->
            <form method="post" id="registration_form" action="<?php echo root::getSelf(); ?>">
                <input type="hidden" name="submitted" id="submitted" value="1">
                <!-- Name -->
                <fieldset>
                    <legend class="<?php echo ( $userMan->isRegFormValid("first") && $userMan->isRegFormValid("last")) ? "normal" : "error"; ?>">Name*</legend>
                    <div>
                        <label for = "first" class="<?php echo ( $userMan->isRegFormValid("first")) ? "normal" : "error"; ?>">First: </label><br/>
                        <input type="text" name="first" id="first" value="<?php root::echoPost("first"); ?>">
                    </div>
                    <div>
                        <label for = "last" class="<?php echo ( $userMan->isRegFormValid("last")) ? "normal" : "error"; ?>">Last: </label><br/>
                        <input type="text" name="last" value="<?php root::echoPost("last"); ?>">
                    </div>
                </fieldset>
                <!-- Gender -->
                <fieldset>
                    <legend class="<?php echo ( $userMan->isRegFormValid("gender")) ? "normal" : "error"; ?>">Gender*</legend>
                    <div class="<?php echo ( $userMan->isRegFormValid("gender")) ? "normal" : "error"; ?>">
                        <label for = "male">Male </label>
                        <input type="radio" name="gender" id="male" value="male" <?php
                        if (root::frmtPost("gender") == "male") {
                            echo "checked=\"checked\"";
                        }
                        ?>><br>
                        <label for = "female">Female </label>
                        <input type="radio" name="gender" id="female" value="female" <?php
                        if (root::frmtPost("gender") == "female") {
                            echo "checked=\"checked\"";
                        }
                        ?>><br>
                        <label for = "other">Other </label>
                        <input type="radio" name="gender" id="other" value="other" <?php
                        if (root::frmtPost("gender") == "other") {
                            echo "checked=\"checked\"";
                        }
                        ?>><br>
                    </div>
                </fieldset>
                <!-- Date of Birth -->
                <fieldset>
                    <legend class="<?php echo ( $userMan->isRegFormValid("month") && $userMan->isRegFormValid("year")) ? "normal" : "error"; ?>">Date of Birth*</legend>
                    <div>
                        <label for = "month" class="<?php echo ( $userMan->isRegFormValid("month")) ? "normal" : "error"; ?>">Month:</label><br>
                        <select name="month" id="monthSelector">
                            <option value = "">Select a Month</option>
                        </select>
                    </div>
                    <div>
                        <label for = "year" class="<?php echo ( $userMan->isRegFormValid("year")) ? "normal" : "error"; ?>">Year:</label><br>
                        <input type="text" name="year" value="<?php root::echoPost("year"); ?>">
                    </div>
                </fieldset>
                <!-- Phone -->
                <fieldset>
                    <legend>Phone Number</legend>
                    Primary Phone:
                    <input type="text" name="phone1" value="<?php root::echoPost("phone1"); ?>">
                    <br> Secondary Phone:
                    <input type="text" name="phone2" value="<?php root::echoPost("phone2"); ?>">
                    <br>
                </fieldset>

                <fieldset>
                    <legend>Address</legend>
                    Street Address:
                    <input type="text" name="line1" value="<?php root::echoPost("line1"); ?>">
<?php
if ($isEmpty["line1"]) {
    echo "<span class=\"error\">*</span>\n";
}
?>
                    <br>Line 2:
                    <input type="text" name="line2" value="<?php root::echoPost("line2"); ?>">
                    <br>City:
                    <input type="text" name="city" value="<?php root::echoPost("city"); ?>">
<?php
if ($isEmpty["city"]) {
    echo "<span class=\"error\">*</span>\n";
}
?>
                    <br>Country:
                    <select name="country" id="countrySelector">
                        <option value = "">Select a Country</option>
                    </select>
<?php
if ($isEmpty["country"]) {
    echo "<span class=\"error\">*</span>\n";
}
?>
                    <br>State:
                    <select name="state" id="stateSelector">
                        <option value = "">Select a State</option>
                    </select>
                    <?php
                    if ($isEmpty["state"] && $isUS) {
                        echo "<span class=\"error\">* </span>\n";
                    }
                    ?>
                    Zipcode:
                    <input type="text" name="zip" value="<?php root::echoPost("zip"); ?>">
<?php
if ($isEmpty["zip"]) {
    echo "<span class=\"error\">*</span>\n";
}
?>
                    <br>
                </fieldset>
                <fieldset>
                    <legend>Email</legend>
                    Email:
                    <input type="text" name="email1" value="<?php root::echoPost("email1"); ?>">
                    <?php
                    if ($isEmpty["email1"]) {
                        echo "<span class=\"error\">*</span>\n";
                    }
                    ?>
                    <br>Verify Email:
                    <input type="text" name="email2" value="<?php root::echoPost("email2"); ?>">
<?php
if ($isEmpty["email2"]) {
    echo "<span class=\"error\">*</span>\n";
}
?>
                    <br>
                </fieldset>
                <fieldset>
                    <legend>User</legend>
                    Desired Username:
                    <input type="text" name="username" value="<?php root::echoPost("username"); ?>">
                    <?php
                    if ($isEmpty["username"]) {
                        echo "<span class=\"error\">*</span>\n";
                    }
                    ?>
                    <br>Password:
                    <input type="text" name="password1">
                    <?php
                    if ($isEmpty["password1"]) {
                        echo "<span class=\"error\">*</span>\n";
                    }
                    ?>
                    <br>Verify Password:
                    <input type="text" name="password2">
<?php
if ($isEmpty["password2"]) {
    echo "<span class=\"error\">*</span>\n";
}
?>
                    <br>
                </fieldset>
                <div class="submitBttnClass">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
    </body>

</html>