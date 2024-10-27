<?php
header('Access-Control-Allow-Origin: *');
session_start();
if (isset($_POST['type']) && $_POST['type'] == 'logout') {
    if (isset($_SESSION["verification_time"])) {
    if ((time() - $_SESSION['verification_time']) > 900) {  // 60*10 Time in Seconds		
        echo 2;
        session_start();
$_SESSION = array();
session_destroy();
header('location: login.php');
die();
    } else {
        echo 1;
        
    }
}
}
?>