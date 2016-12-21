<?php
	include "Database.php";
    $database = new Database;

	$username = $_POST["username"];
	
	$response = array();
	$response["success"] = false;  
	
	$response = $database->getFriends($username);
	
    echo json_encode($response);
	
	
?>