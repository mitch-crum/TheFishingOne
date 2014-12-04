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
    private $DB_connection;
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
        reset($this->regFormValues);
        foreach ($this->regFormValues as $key => $entity) {
            if (filter_has_var(INPUT_POST, $key)) {
                // IMPORTANT!!! In order to securely/correctly display the form values, htmlentities() MUST be used first as quotes
                // are not filtered
                $this->regFormValues[$key] = trim(filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            }
        }
    }
    
    function login() {
        if (!$this->DB_Login()) {
            error_log( "Failed to login to DB");
            return false;
        }
        //Check User
        $username = mysql_real_escape_string($this->loginFormValues["username"]);
        $password = md5($this->loginFormValues["password"]);
        $qry = "Select FIRSTNAME, EMAIL from `$this->DB_table` where username='$username' and password='$password'";
        $result = mysql_query($qry,$this->DB_connection);
        if(!$result || mysql_num_rows($result) <= 0)
        {
            error_log("Error logging in. The username or password does not match");
            return false;
        }
        return true;
    }
    
    function getLoginFormData() {
        reset($this->loginFormValues);
        foreach ($this->loginFormValues as $key => $entity) {
            if (filter_has_var(INPUT_POST, $key)) {
                // IMPORTANT!!! In order to securely/correctly display the form values, htmlentities() MUST be used first as quotes
                // are not filtered
                $this->loginFormValues[$key] = trim(filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
            }
        }
    }
    
    function regFormHTML($key) {
        return htmlentities(root::sanitize($this->regFormValues[$key]));
    }

    function regFormSafeDisplace($key) {
        echo $this->regFormHTML($key);
    }
    
    function loginFormHTML($key) {
        return htmlentities(root::sanitize($this->loginFormValues[$key]));
    }

    function loginFormSafeDisplace($key) {
        echo $this->loginFormHTML($key);
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
    
    function regFormIsValid($key=null) {
        if ( $key!=null) {
            return ( $this->regFormValids[$key]);
        }
        else {
            foreach ($this->regFormValids as $keyIndex => $entity) {
                if (!$entity) {
                    return false;
                }
            }
            return true;
        }
    }
    
    function DB_Init( $host, $username, $password, $database, $table) {
        $this->DB_host = $host;
        $this->DB_username = $username;
        $this->DB_password = $password;
        $this->DB_db = $database;
        $this->DB_table = $table;
    }
    
    function DB_Login( ) {
        $this->DB_connection = mysql_connect( $this->DB_host, $this->DB_username, $this->DB_password);
        if (!$this->DB_connection) {
            error_log("Couldn't Connect to DB");
            return false;
        }
        if (!mysql_select_db($this->DB_db)) {
            error_log("Couldn't select DB");
            return false;
        }
        if (!mysql_query("SET NAMES 'UTF8'", $this->DB_connection)) {
            error_log("Couldn't set character encoding");
            return false;
        }
        return true;
    }
    
    function DB_addUser( ) {
        if (!$this->DB_Login( )) {
            error_log( "Failed to login to DB");
            return false;
        }
        // does table exists?
        $result = mysql_query("SHOW COLUMNS FROM `$this->DB_table`");   
        if(!$result || mysql_num_rows($result) <= 0)
        {
            return $this->CreateTable();
        }
        // check unique user
        if( !$this->DB_isFieldUnique( $this->regFormValues,"email1"))
        {
            error_log("This email is already registered");
            return false;
        }
        
        if( !$this->DB_isFieldUnique( $this->regFormValues,"username"))
        {
            error_log("This UserName is already used. Please try another username");
            return false;
        }        
        if( !$this->DB_insertUser( $this->regFormValues))
        {
            error_log("Inserting to Database failed!");
            return false;
        }
        return true;
    }
    
    function DB_isFieldUnique($formvars,$fieldname)
    {
        $field_val = mysql_real_escape_string($formvars[$fieldname]);
        $qry = "SELECT username FROM `$this->DB_table` WHERE $fieldname='".$field_val."'";
        $result = mysql_query($qry,$this->DB_connection);   
        if($result && mysql_num_rows($result) > 0)
        {
            return false;
        }
        return true;
    }
    
    function DB_insertUser( $formvars) {
        $confirmCode = $this->generateConfirmCode($formvars["email1"]);
        $query = "INSERT INTO `$this->DB_table`"
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
                . "'" . $formvars["username"] . "',"
                . "'".md5($formvars["password1"])."',"
                . "'" . $formvars["first"] . "',"
                . "'" . $formvars["last"] . "',"
                . "'" . $formvars["email1"] . "',"
                . "'" . $formvars["phone1"] . "',"
                . "'" . $formvars["phone2"] . "',"
                . "'" . $formvars["line1"] . "',"
                . "'" . $formvars["line2"] . "',"
                . "'" . $formvars["city"] . "',"
                . "'" . $formvars["state"] . "',"
                . "'" . $formvars["country"] . "',"
                . "'" . $formvars["zip"] . "',"
                . "'" . $formvars["gender"] . "',"
                . "'" . $formvars["year"] . "',"
                . "'" . $formvars["month"] . "',"
                . "'" . $confirmCode . "',"
                . "'" . false . "'"
                . ")"
                ;
        if(!mysql_query( $query ,$this->DB_connection))
        {
            error_log("Error inserting data to the table\nquery:$query");
            return false;
        }        
        return true;
    }
    
    function generateConfirmCode( $email) {
        return md5( $email . rand() . self::rndSeed . rand());
    }
}

?>