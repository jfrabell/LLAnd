<?php

	include "Database.php";
    $database = new Database;

	$username = $_POST["username"];
    $token = $_POST["id"];

	$response = array();
	$response["success"] = false;  
	
	$response = $database->store_token($username,$token);
	
    echo json_encode($response);


?>
