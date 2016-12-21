<?php

	include "Database.php";
    $database = new Database;
    $username = $_GET["username"];
    $response = array();
	$response["success"] = false;  
	$response = $database->changePrivacy($username);
    echo json_encode($response);		
?>
