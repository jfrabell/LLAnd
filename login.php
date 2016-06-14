<?php

	include "Database.php";
    $database = new Database;
		
    $username = $_POST["username"];
    $password = $_POST["password"];
    $response = array();
	$response["success"] = false;  
	
	
	$response = $database->login($username,$password);
	

    echo json_encode($response);
	



		
?>
