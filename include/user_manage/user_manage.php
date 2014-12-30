<?PHP

require_once( __DIR__ . "/../rootFunc.php");

class UserMan {

    const rndSeed = "910212d01c6ca98d108561a645b21e84";

    //Server Side User/Pass & Info
    private $DB_host;
    private $DB_username = "";
    private $DB_password = "";
    private $DB_db = "";
    private $DB_table = "";
    private $DB_object;
    // prepared statements
    private $DB_STMT_insertNewUser;
    private $DB_STMT_isUserValueUnique;
    private $DB_STMT_checkTable;
    private $DB_STMT_login;
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
    // login form values
    private $loginFormValues = array("username" => "", "password" => "");
    private $loginFormValids = array("username" => false, "password" => false);

    //private table

    function getRegFormData() {
        $this->getFormData($this->regFormValues);
    }

    function getLoginFormData() {
        $this->getFormData($this->loginFormValues);
    }

    function getFormData(&$formValues) {
        reset($formValues);
        foreach ($formValues as $key => $entity) {
            if (filter_has_var(INPUT_POST, $key)) {
                // IMPORTANT!!! In order to securely/correctly display the form values, htmlentities() MUST be used first as quotes
                // are not filtered
                $formValues[$key] = root::sanitize(filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            }
        }
    }

    function regFormSafeDisplace($key) {
        echo $this->formHTML($this->regFormValues, $this->regFormValids, $key);
    }

    function loginFormSafeDisplace($key) {
        echo $this->formHTML($this->loginFormValues, $this->loginFormValids, $key);
    }

    function formHTML($formvalues, $formValids, $key) {
        if ($formValids[$key]) {
            return htmlentities(root::sanitize($formvalues[$key]));
        } else {
            return "";
        }
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
                    $this->regFormGenerateRegexError(( $valFrmt || !$filledIn), $key, "name"); // Gen Error
                    break;
                // Phone 1
                case "phone1":
                    $valFrmt = root::hasCorrectChars($entity, "phone");
                    $this->regFormValids[$key] = ( $filledIn && $valFrmt);
                    $this->regFormGenerateRegexError(( $valFrmt || !$filledIn), $key, "phone"); // Gen Error
                    break;
                // Address
                case "line1":
                case "city":
                    $valFrmt = root::hasCorrectChars($entity, "address");
                    $this->regFormValids[$key] = ( $filledIn && $valFrmt);
                    $this->regFormGenerateRegexError(( $valFrmt || !$filledIn), $key, "address"); // Gen Error
                    break;
                case "zip":
                    $valFrmt = root::hasCorrectChars($entity, "zipcode");
                    $this->regFormValids[$key] = ( $filledIn && $valFrmt);
                    $this->regFormGenerateRegexError(( $valFrmt || !$filledIn), $key, "zipcode"); // Gen Error
                    break;
                // Email
                case "email1":
                case "email2":
                    $matches = $this->regFormValues["email1"] == $this->regFormValues["email2"];
                    $valFrmt = root::hasCorrectChars($entity, "email");
                    $this->regFormValids[$key] = ( $filledIn && $valFrmt && $matches);
                    !$matches && $key != "email1" ? $this->regFormLogError("Emails do not match!") : // Gen Error
                                    $this->regFormGenerateRegexError(( $valFrmt || !$filledIn), $key, "email");
                    break;
                // Username
                case "username":
                    $valFrmt = root::hasCorrectChars($entity, "username");
                    $this->regFormValids[$key] = ( $filledIn && $valFrmt);
                    $this->regFormGenerateRegexError(( $valFrmt || !$filledIn), $key, "username"); // Gen Error
                    break;
                // Password
                case "password1":
                case "password2":
                    $matches = $this->regFormValues["password1"] == $this->regFormValues["password2"];
                    $valFrmt = root::hasCorrectChars($entity, "password");
                    $this->regFormValids[$key] = ( $filledIn && $valFrmt && $matches);
                    !$matches && $key != "password1" ? $this->regFormLogError("Passwordss do not match!") : // Gen Error
                                    $this->regFormGenerateRegexError(( $valFrmt || !$filledIn), $key, "password");
                    break;
                // Optional forms
                case "line2":
                case "phone2":
                    $valFrmt = root::hasCorrectChars($entity, $key == "line2" ? "address" : "phone");
                    $this->regFormValids[$key] = (!$filledIn || $valFrmt);
                    $this->regFormGenerateRegexError(( $valFrmt || !$filledIn), $key, $key == "line2" ? "address" : "phone"); // Gen Error
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
        if (!$valid) {
            $this->regFormLogError($this->regFormFriendlyName[$key] . " is invalid.");
        }
    }

    function regFormLogError($str) {
        array_push($this->regFormErrors, $str);
    }

    function echoRegFormErrors() {
        foreach ($this->regFormErrors as $error) {
            echo $error . "<br>";
        }
    }

    function regFormIsValid($key = null) {
        if ($key != null) {
            return ( $this->regFormValids[$key]);
        } else {
            foreach ($this->regFormValids as $keyIndex => $entity) {
                if (!$entity) {
                    return false;
                }
            }
            return true;
        }
    }

    function DB_init($host, $username, $password, $database, $table) {
        $this->DB_host = $host;
        $this->DB_username = $username;
        $this->DB_password = $password;
        $this->DB_db = $database;
        $this->DB_table = $table;
    }

    function DB_connect() {
        $this->DB_object = new mysqli($this->DB_host, $this->DB_username, $this->DB_password);
        if ($this->DB_object->connect_error) {
            error_log("Couldn't Connect to DB");
            return false;
        }
        if (!$this->DB_object->select_db($this->DB_db)) {
            error_log("Couldn't select DB");
            return false;
        }
        if (!$this->DB_object->query("SET NAMES 'UTF8'")) {
            error_log("Couldn't set character encoding");
            return false;
        }
        $this->DB_prepareStatements();
        return true;
    }

    function DB_prepareStatements() {
        $this->DB_STMT_checkTable = $this->DB_object->prepare("SHOW COLUMNS FROM `$this->DB_table`");
        $this->DB_STMT_isUserValueUnique = $this->DB_object->prepare("SELECT ? FROM `$this->DB_table` WHERE username = ?");
        $q = "INSERT INTO `$this->DB_table`"
                . "("
                . "username,"
                . "password,"
                . "firstname,"
                . "lastname,"
                . "email,"
                . "phone1,"
                . "phone2,"
                . "address1,"
                . "address2,"
                . "city,"
                . "state,"
                . "country,"
                . "zipcode,"
                . "gender,"
                . "year,"
                . "month,"
                . "confirmcode,"
                . "confirmed"
                . ")"
                . "values( "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?, "
                . "?"
                . ")"
        ;
        $this->DB_STMT_insertNewUser = $this->DB_object->prepare($q);
        $this->DB_STMT_login = $this->DB_object->prepare( "Select FIRSTNAME, EMAIL, PASSWORD from `$this->DB_table` where username=?");
    }

    function DB_addUser() {
        if (!$this->DB_connect()) {
            error_log("Failed to login to DB");
            return false;
        }
        // check unique user
        if (!$this->DB_isEmailUnique( $this->regFormValues["email1"])) {
            error_log("This email is already registered");
            $this->regFormLogError("This email is already registered");
            return false;
        }

        if (!$this->DB_isUsernameUnique( $this->regFormValues["username"])) {
            error_log("This UserName is already used. Please try another username");
            $this->regFormLogError("This username is already used. Please try another username");
            return false;
        }
        if (!$this->DB_insertUser($this->regFormValues)) {
            error_log("Inserting to Database failed!");
            return false;
        }
        return true;
    }

    function DB_isUsernameUnique( $username) {
        return $this->DB_isUserValueUnique( "username", $username);
    }
    
    function DB_isEmailUnique( $email) {
        return $this->DB_isUserValueUnique( "email", $email);
    }
    
    function DB_isUserValueUnique( $field, $value) {
        $value = mysql_real_escape_string($value);
        $field = mysql_real_escape_string($field);
        // reprepare stmt
        $this->DB_STMT_isUserValueUnique = $this->DB_object->prepare( "SELECT $field FROM `$this->DB_table` WHERE $field = ?");
        // bind param
        $this->DB_STMT_isUserValueUnique->bind_param( "s", $value);
        // query
        $this->DB_STMT_isUserValueUnique->execute( );
        //bind results
        $this->DB_STMT_isUserValueUnique->store_result();
        if ($this->DB_STMT_isUserValueUnique->num_rows != 0) {
            return false;
        }
        return true;
    }

    function DB_insertUser($formvars) {
        $confirmCode = $this->generateConfirmCode($formvars["email1"]);
        $passwordCrypt = password_hash($formvars[ "password1"], PASSWORD_DEFAULT);
        $confirmed = false;
        $this->DB_STMT_insertNewUser->bind_param( "sssssssssssssssssi", 
                $formvars["username"],
                $passwordCrypt,
                $formvars["first"],
                $formvars["last"],
                $formvars["email1"],
                $formvars["phone1"],
                $formvars["phone2"],
                $formvars["line1"],
                $formvars["line2"],
                $formvars["city"],
                $formvars["state"],
                $formvars["country"],
                $formvars["zip"],
                $formvars["gender"],
                $formvars["year"],
                $formvars["month"],
                $confirmCode,
                $confirmed);
        if (!$this->DB_STMT_insertNewUser->execute()) {
            error_log("Error inserting data to the table");
            return false;
        }
        return true;
    }

    function login() {
        if (!$this->DB_connect()) {
            error_log("Failed to login to DB");
            return false;
        }
        // vars
        $retUsername = $email = $password = "";
        //Check User
        $username = mysql_real_escape_string($this->loginFormValues["username"]);
        $this->DB_STMT_login->bind_param( "s", $username);
        $this->DB_STMT_login->execute();
        $this->DB_STMT_login->store_result();
        $this->DB_STMT_login->bind_result( $retUsername, $email, $password);
        // no users found
        if ($this->DB_STMT_login->num_rows < 1) {
            error_log("Error logging in. User not found!");
            return false;
        }
        // more than one pass
        if ($this->DB_STMT_login->num_rows > 1) {
            error_log("Error logging in. More than one user returned!");
            return false;
        }
        $this->DB_STMT_login->fetch( );
        //check password
        if ( !password_verify($this->loginFormValues["password"], $password)) {
            error_log("Error logging in. Passwords do not match");
            return false;
        }
        return true;
    }

    function generateConfirmCode($email) {
        return md5($email . rand() . self::rndSeed . rand());
    }

}

?>