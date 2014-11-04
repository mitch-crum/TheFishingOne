<?PHP

require_once( __DIR__ . "/../rootFunc.php");

class UserMan {

    private $user = "";
    private $pswd = "";
    // reg form vars
    private $regFormValues = array("first" => "", "last" => "", "gender" => "", "month" => "",
        "year" => "", "phone1" => "", "phone2" => "",
        "line1" => "", "line2" => "", "city" => "", "country" => "", "state" => "",
        "zip" => "", "email1" => "", "email2" => "",
        "username" => "", "password1" => "", "password2" => "");
    private $regFormValids = array("first" => false, "last" => false, "gender" => false, "month" => false,
        "year" => false, "phone1" => false, "phone2" => false,
        "line1" => false, "line2" => false, "city" => false, "country" => false, "state" => false,
        "zip" => false, "email1" => false, "email2" => false,
        "username" => false, "password1" => false, "password2" => false);
    private $regFormFriendlyName = array("first" => "First Name", "last" => "Last Name", "gender" => "Gender", "month" => "Month for Date of Brith",
        "year" => "Year for Date of Birth", "phone1" => "Primary Phone", "phone2" => "Secondary Phone",
        "line1" => "Address", "line2" => "Address Line 2", "city" => "City", "country" => "Country", "state" => "State",
        "zip" => "Zipcode", "email1" => "Email", "email2" => "Verify Email",
        "username" => "Username", "password1" => "Password", "password2" => "Verify Password");
    private $regFormErrors = array();

    function getRegFormData() {
        reset($this->regFormValues);
        foreach ($this->regFormValues as $key => $entity) {
            if (filter_has_var(INPUT_POST, $key)) {
                // IMPORTANT!!! In order to securely/correctly display the form values, htmlentities() MUST be used first as quotes
                // are not filtered
                $this->regFormValues[$key] = trim(filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            }
        }
    }

    function regFormHTML($key) {
        return htmlentities(root::sanitize($this->regFormValues[$key]));
    }

    function regFormSafeDisplace($key) {
        echo $this->regFormHTML($key);
    }

    function regFormsValidate() {
        reset($this->regFormValues);
        foreach ($this->regFormValues as $key => $entity) {
            $filledIn = ( $entity != "");
            $valFrmt = true;
            $matches = true;
            switch ($key) {
                // Name
                case "first":
                case "last":
                    $valFrmt = root::hasCorrectChars($entity, "name");
                    $this->regFormValids[$key] = ($filledIn && $valFrmt);
                    $this->regFormGenerateRegexError( ( $valFrmt || !$filledIn), $key, "name"); // Gen Error
                    break;
                // Phone 1
                case "phone1":
                    $valFrmt = root::hasCorrectChars($entity, "phone");
                    $this->regFormValids[$key] = ( $filledIn && $valFrmt);
                    $this->regFormGenerateRegexError( ( $valFrmt || !$filledIn), $key, "phone"); // Gen Error
                    break;
                // Address
                case "line1":
                case "city":
                    $valFrmt = root::hasCorrectChars($entity, "address");
                    $this->regFormValids[$key] = ( $filledIn && $valFrmt);
                    $this->regFormGenerateRegexError( ( $valFrmt || !$filledIn), $key, "address"); // Gen Error
                    break;
                case "zip":
                    $valFrmt = root::hasCorrectChars($entity, "zipcode");
                    $this->regFormValids[$key] = ( $filledIn && $valFrmt);
                    $this->regFormGenerateRegexError( ( $valFrmt || !$filledIn), $key, "zipcode"); // Gen Error
                    break;
                // Email
                case "email1":
                case "email2":
                    $matches = $this->regFormValues["email1"] == $this->regFormValues["email2"];
                    $valFrmt = root::hasCorrectChars($entity, "email");
                    $this->regFormValids[$key] = ( $filledIn && $valFrmt && $matches);
                    !$matches && $key!="email1" ? $this->regFormLogError( "Emails do not match!") : // Gen Error
                        $this->regFormGenerateRegexError( ( $valFrmt || !$filledIn), $key, "email");
                    break;
                // Username
                case "username":
                    $valFrmt = root::hasCorrectChars($entity, "username");
                    $this->regFormValids[$key] = ( $filledIn && $valFrmt);
                    $this->regFormGenerateRegexError( ( $valFrmt || !$filledIn), $key, "username"); // Gen Error
                    break;
                // Password
                case "password1":
                case "password2":
                    $matches = $this->regFormValues["password1"] == $this->regFormValues["password2"];
                    $valFrmt = root::hasCorrectChars($entity, "password");
                    $this->regFormValids[$key] = ( $filledIn && $valFrmt && $matches);
                    !$matches && $key!="password1" ? $this->regFormLogError( "Passwordss do not match!") : // Gen Error
                        $this->regFormGenerateRegexError( ( $valFrmt || !$filledIn), $key, "password");
                    break;
                // Optional forms
                case "line2":
                case "phone2":
                    $valFrmt = root::hasCorrectChars($entity, $key == "line2" ? "address" : "phone");
                    $this->regFormValids[$key] = (!$filledIn || $valFrmt);
                    $this->regFormGenerateRegexError( ( $valFrmt || !$filledIn), $key, $key == "line2" ? "address" : "phone"); // Gen Error
                    break;
                // Sometimes optional
                case "state":
                    $this->regFormValids[$key] = ( $filledIn || $this->regFormValues["country"] != "US");
                    break;
                default:
                    $this->regFormValids[$key] = ( $filledIn);
                    break;
            }
        }
    }

    function regFormGenerateRegexError($valid, $key, $type) {
        // MORE TODO HERE
        if ( !$valid) {
            $this->regFormLogError( $this->regFormFriendlyName[ $key] . " is invalid.");
        }
    }

    function regFormLogError($str) {
        array_push($this->regFormErrors, $str);
    }

    function echoRegFormErrors( ) {
        foreach ($this->regFormErrors as $error) {
            echo $error . "<br>";
        }
    }
    
    function regFormIsValid($key) {
        return ( $this->regFormValids[$key]);
    }

}

?>