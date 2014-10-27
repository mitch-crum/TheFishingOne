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
        return ( $str);
    }

}

?>