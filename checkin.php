<?php

	include "Database.php";
    $database = new Database;

	$username = $_REQUEST["username"];
    $overnight = $_REQUEST["overnight"];

	$response = array();
	$response["success"] = false;  
	
	$response = $database->checkIn($username,$overnight);
	
	$response["checkit"] = "Yippee";

    echo json_encode($response);


?>
