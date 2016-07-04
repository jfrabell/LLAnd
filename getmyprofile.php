<?php
	include "Database.php";
    $database = new Database;
	$username = $_GET["username"];
	$response = array();
	$response["success"] = false;  	
	$response = $database->getMyProfile($username);

    echo json_encode($response);
	
?>