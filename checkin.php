<?php

	include "Database.php";
    $database = new Database;

	$username = $_POST["username"];
    $overnight = $_POST["overnight"];

	$response = array();
	$response["success"] = false;  
	
	$response = $database->checkIn($username,$overnight);
	

    echo json_encode($response);


?>
