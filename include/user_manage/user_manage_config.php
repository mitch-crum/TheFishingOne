<?PHP
require_once( __DIR__ . "/user_manage.php");
$userMan = new UserMan( );
$userMan->DB_Init( "localhost", "WF", "WF", "WEFISH", "USERSTORE")
?>