<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
    <title>Register</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="/reg.js"></script>
</head>

<body>
	<?php
	// form data vars
	$first = $last = $gender = $month = $year = $phone = $line1 = $line2 = $city = "";
	$country = $state = $zip = $email1 = $email2 = $username = $password1 = $password2 = "";
	
	
	// parse form input
	function parse_form_input( $data) {
		$data = htmlspecialchars( stripcslashes( trim( $data)));
	}
	?>
    <!-- Form Entry -->
    <form method="post" action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"]); ?>">
        <fieldset>
            <legend>Name</legend>
            First:
            <input type="text" name="first">
            <br>Last:
            <input type="text" name="last">
            <br>
        </fieldset>
        <fieldset>
            <legend>Gender</legend>
            <input type="radio" name="gender" value="male">Male
            <input type="radio" name="gender" value="female">Female
            <input type="radio" name="gender" value="other">Other
        </fieldset>
        <fieldset>
            <legend>Date of Birth</legend>
            Month:
            <select name="month" id="monthSelector">
			<option value = "">Select a Month</option>
            </select>
            Year:
            <input type="text" name="year">
        </fieldset>
        <fieldset>
            <legend>Phone Number</legend>
            Primary Phone:
            <input type="text" name="phone1">
            <br> Secondary Phone:
            <input type="text" name="phone2">
            <br>
        </fieldset>
        <fieldset>
            <legend>Address</legend>
            Street Address:
            <input type="text" name="line1">
            <br>Line 2:
            <input type="text" name="line2">
            <br>City:
            <input type="text" name="city">
            <br>Country:
            <select name="country" id="countrySelector">
			<option value = "">Select a Country</option>
            </select>
            <br>State:
            <select name="state" id="stateSelector">
			<option value = "">Select a State</option>
            </select>
            Zipcode:
            <input type="text" name="zip">
            <br>
        </fieldset>
        <fieldset>
            <legend>Email</legend>
            Email:
            <input type="text" name="email1">
            <br>Verify Email:
            <input type="text" name="email2">
            <br>
        </fieldset>
        <fieldset>
            <legend>User</legend>
            Desired Username:
            <input type="text" name="username">
            <br>Password:
            <input type="text" name="password1">
            <br>Verify Password:
            <input type="text" name="password2">
            <br>
        </fieldset>
        <br>
        <input type="submit" value="Submit">
    </form>
</body>

</html>