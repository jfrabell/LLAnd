<?php
$username = $_POST["username"];
$password = $_POST["password"];
if($username == "jfrabell" && $password == "chicken"){
	session_start();
	$_SESSION["token"]="8675309";
header('Location: http://ll.bunnyhutt.com/dealsmanager/home.php');
} else {
	echo "Not authorized";
}

?>