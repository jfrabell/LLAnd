<?php
	include "Database.php";
    $database = new Database;
	$username = $_GET["username"];
	$firstName = $_GET["firstname"];
	$lastName = $_GET["lastname"];
	$email = $_GET["email"];
	$response = array();
	$response["success"] = false;  	
	$response = $database->updateMyProfile($username,$firstName,$lastName,$email);

    echo json_encode($response);
	
?>