<?PHP
require_once( __DIR__."/../rootFunc.php");
class UserMan {
	private $user = "";
	private $pswd = "";
	
	function isRegFormValid( $id) {
		return ( root::frmtPost( $id) != "" || !isset( $_POST[ "submitted"]));
	}
}
?>