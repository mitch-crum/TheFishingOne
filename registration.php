<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
    <title>Register</title>
	<link rel="stylesheet" type="text/css" href="reg.css">
	
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript">
	var Selections = {
		month: "<?php echo_preivious( "month")?>",
		state: "<?php echo_preivious( "state")?>",
		country: "<?php echo_preivious( "country")?>"
	}
	</script>
    <script type="text/javascript" src="reg.js"></script>
</head>

<body>
	<?php
	// form data vars
	$first = $last = $gender = $month = $year = $phone1 = $phone2 = $line1 = $line2 = $city = "";
	$country = $state = $zip = $email1 = $email2 = $username = $password1 = $password2 = "";
	
	// "is empty" array
	$isEmpty = array( "first" => false, "last" => false, "gender" => false, "gender" => false, "month" => false, "year" => false, "phone1" => false, 
	"phone2" => false, "line1" => false, "line2" => false, "city" => false, "state" => false, "country" => false, "zip" => false, "email1" => false,
	"email2" => false, "username" => false, "password1" => false, "password2" => false);
	
	// bools
	$formSubmitted = $isUS = $missingRequired = false;
	
	// fix input
	function fix_input( $data) {
		return htmlspecialchars( stripcslashes( trim( $data)));
	}
	
	// parse form input
	function parse_form_input( $id) {
		global $missingRequired, $country, $isEmpty;
		$isEmpty[ $id] = empty( $_POST[ $id]);
		$data = "";
		if ( !$isEmpty[ $id]) {
			$data = fix_input( $_POST[ $id]);
		}
		else {
			switch ( $id) {
				case "state":
					if ( $country == "US") {
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
	function echo_preivious( $id) {
		if ( isset( $_POST[ $id])) {
			echo fix_input( $_POST[ $id]);
		}
	}
	
	// Has a form been submitted ?
	$formSubmitted = ( $_SERVER["REQUEST_METHOD"] == "POST");
	
	// Parse Form Data if it has been submitted
	if ( $formSubmitted) {
		$first = parse_form_input( "first");
		$last = parse_form_input( "last");
		
		$gender = parse_form_input( "gender");
		
		$month = parse_form_input( "month");
		$year = parse_form_input( "year");
		
		$phone1 = parse_form_input( "phone1");
		$phone2 = parse_form_input( "phone2");
		
		$line1 = parse_form_input( "line1");
		$line2 = parse_form_input( "line2");	
		$city = parse_form_input( "city");
		$country = parse_form_input( "country");
		$isUS = ( $country == "US");
		$state = parse_form_input( "state");
		$zipcode = parse_form_input( "zip");
		
		$email1 = parse_form_input( "email1");
		$email2 = parse_form_input( "email2");
		
		$username = parse_form_input( "username");
		$password1 = parse_form_input( "password1");
		$password2 = parse_form_input( "password2");
	}
	?>
	
	<!-- Errors -->
	<p>
		<span class="error">
		<?php 
			//check if missing required fields
			if ( $missingRequired) {
				echo "* required fields\n";
			}
		?>
			<span class="invalid">
			</span>
		</span>
	</p>
	<div class="formDiv">
    <!-- Form Entry -->
    <form method="post" action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"]); ?>">
        <fieldset>
            <legend>Name</legend>
            First:
            <input type="text" name="first" value="<?php echo_preivious( "first"); ?>">
			<?php 
			if ( $isEmpty[ "first"]) { 
				echo "<span class=\"error\">*</span>\n";
			} 
			?>
            <br>Last:
            <input type="text" name="last" value="<?php echo_preivious( "last"); ?>">
			<?php 
			if ( $isEmpty[ "last"]) { 
				echo "<span class=\"error\">*</span>\n";
			} 
			?>
            <br>
        </fieldset>
        <fieldset>
            <legend>Gender</legend>
            <input type="radio" name="gender" value="male" <?php if($gender=="male"){echo "checked=\"checked\"";}?>>Male
            <input type="radio" name="gender" value="female" <?php if($gender=="female"){echo "checked=\"checked\"";}?>>Female
            <input type="radio" name="gender" value="other" <?php if($gender=="other"){echo "checked=\"checked\"";}?>>Other
			<?php 
			if ( $isEmpty[ "gender"]) { 
				echo "<span class=\"error\">*</span>\n";
			} 
			?>
        </fieldset>
        <fieldset>
            <legend>Date of Birth</legend>
            Month:
            <select name="month" id="monthSelector">
			<option value = "">Select a Month</option>
            </select>
			<?php 
			if ( $isEmpty[ "month"]) { 
				echo "<span class=\"error\">* </span>\n";
			} 
			?>
            Year:
            <input type="text" name="year" value="<?php echo_preivious( "year"); ?>">
			<?php 
			if ( $isEmpty[ "year"]) { 
				echo "<span class=\"error\">*</span>\n";
			} 
			?>
        </fieldset>
        <fieldset>
            <legend>Phone Number</legend>
            Primary Phone:
            <input type="text" name="phone1" value="<?php echo_preivious( "phone1"); ?>">
			<?php 
			if ( $isEmpty[ "phone1"]) { 
				echo "<span class=\"error\">*</span>\n";
			} 
			?>
            <br> Secondary Phone:
            <input type="text" name="phone2" value="<?php echo_preivious( "phone2"); ?>">
            <br>
        </fieldset>
        <fieldset>
            <legend>Address</legend>
            Street Address:
            <input type="text" name="line1" value="<?php echo_preivious( "line1"); ?>">
			<?php 
			if ( $isEmpty[ "line1"]) { 
				echo "<span class=\"error\">*</span>\n";
			} 
			?>
            <br>Line 2:
            <input type="text" name="line2" value="<?php echo_preivious( "line2"); ?>">
            <br>City:
            <input type="text" name="city" value="<?php echo_preivious( "city"); ?>">
			<?php 
			if ( $isEmpty[ "city"]) { 
				echo "<span class=\"error\">*</span>\n";
			} 
			?>
            <br>Country:
            <select name="country" id="countrySelector">
			<option value = "">Select a Country</option>
            </select>
			<?php 
			if ( $isEmpty[ "country"]) { 
				echo "<span class=\"error\">*</span>\n";
			} 
			?>
            <br>State:
            <select name="state" id="stateSelector">
			<option value = "">Select a State</option>
            </select>
			<?php 
			if ( $isEmpty[ "state"] && $isUS) { 
				echo "<span class=\"error\">* </span>\n";
			} 
			?>
            Zipcode:
            <input type="text" name="zip" value="<?php echo_preivious( "zip"); ?>">
			<?php 
			if ( $isEmpty[ "zip"]) { 
				echo "<span class=\"error\">*</span>\n";
			} 
			?>
            <br>
        </fieldset>
        <fieldset>
            <legend>Email</legend>
            Email:
            <input type="text" name="email1" value="<?php echo_preivious( "email1"); ?>">
			<?php 
			if ( $isEmpty[ "email1"]) { 
				echo "<span class=\"error\">*</span>\n";
			} 
			?>
            <br>Verify Email:
            <input type="text" name="email2" value="<?php echo_preivious( "email2"); ?>">
			<?php 
			if ( $isEmpty[ "email2"]) { 
				echo "<span class=\"error\">*</span>\n";
			} 
			?>
            <br>
        </fieldset>
        <fieldset>
            <legend>User</legend>
            Desired Username:
            <input type="text" name="username" value="<?php echo_preivious( "username"); ?>">
			<?php 
			if ( $isEmpty[ "username"]) { 
				echo "<span class=\"error\">*</span>\n";
			} 
			?>
            <br>Password:
            <input type="text" name="password1">
			<?php 
			if ( $isEmpty[ "password1"]) { 
				echo "<span class=\"error\">*</span>\n";
			} 
			?>
            <br>Verify Password:
            <input type="text" name="password2">
			<?php 
			if ( $isEmpty[ "password2"]) { 
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