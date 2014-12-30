<?PHP

class root {

    public static function echoPost($id) {
        echo self::frmtPost($id);
    }

    public static function frmtPost($id, $san = true) {
        if (empty($_POST[$id])) {
            return ( "");
        }
        return ( $san ? self::sanitize(htmlentities($_POST[$id])) : htmlentities($_POST[$id]));
    }

    public static function echoSelf() {
        echo getSelf();
    }

    public static function getSelf() {
        return ( htmlentities($_SERVER['PHP_SELF']));
    }

    public static function sanitize($str, $trim = true, $rem_newline = true) {
        $str = stripslashes($str);
        if ($trim) {
            $str = trim($str);
        }
        if ($rem_newline) {
            $injections = array('/(\n+)/i',
                '/(\r+)/i',
                '/(\t+)/i',
                '/(%0A+)/i',
                '/(%0D+)/i',
                '/(%08+)/i',
                '/(%09+)/i'
            );
            $str = preg_replace($injections, '', $str);
        }
        return mysql_real_escape_string( $str);
    }

    public static function hasCorrectChars( $str, $delim) {
        switch ( $delim) {
            case "phone" :
                return ( filter_var( $str, FILTER_VALIDATE_REGEXP,
                    array("options" => array("regexp" => "/^(\+\d{1,2}\s*)?\(?\d{3}\)?\s*-?\d{3}\s*-?\d{4}$/")))!=false);
            case "email":
                return ( filter_var( $str, FILTER_VALIDATE_EMAIL)!=false);
            case "name": 
                return ( filter_var( $str, FILTER_VALIDATE_REGEXP,
                    array("options" => array("regexp" => "/^[A-Za-z\s]+$/")))!=false);
            case "address": 
                return ( filter_var( $str, FILTER_VALIDATE_REGEXP,
                    array("options" => array("regexp" => "/^[A-Za-z\d\s]+$/")))!=false);
            case "zipcode": 
                return ( filter_var( $str, FILTER_VALIDATE_REGEXP,
                    array("options" => array("regexp" => "/^[\d]+$/")))!=false);
            case "username": 
                return ( filter_var( $str, FILTER_VALIDATE_REGEXP,
                    array("options" => array("regexp" => "/^[\w]+$/")))!=false);
            case "password": 
                return ( filter_var( $str, FILTER_VALIDATE_REGEXP,
                    array("options" => array("regexp" => "/^[\w!@#$%^&*]{6,16}$/")))!=false);
            default:
                return ( filter_var( $str, FILTER_VALIDATE_REGEXP,
                    array("options" => array("regexp" => $delim)))!=false);
        }
    }

}

?>