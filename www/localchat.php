<?php

	include "Database.php";
    $database = new Database;

	$chattingWith = $_REQUEST["with"];
	$userName = $_REQUEST["user"];
	$city = $_REQUEST["city"];

	$response = array();
	$response["success"] = false;  
	
	$response = $database->local_chat($chattingWith,$userName,$city);
	
    echo json_encode($response);
	
	$numberOfRecords = (count($response) - 1)/4; 

?>
