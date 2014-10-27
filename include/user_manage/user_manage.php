<?PHP
require_once( __DIR__ . "/../rootFunc.php");
class UserMan {

    private $user = "";
    private $pswd = "";

    function isRegFormValid($id) {
        if ($id != "state") {
            return ( root::frmtPost($id) != "" || !isset($_POST["submitted"]));
        } else {
            return ( root::frmtPost($id) != "" || !isset($_POST["submitted"]) || root::frmtPost("country") != "US");
        }
    }
}
?>