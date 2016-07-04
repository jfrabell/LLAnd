<?php

	include "Database.php";
    $database = new Database;
    $city = $_GET["city"];
    $response = array();
	$response["success"] = false;  
	$response = $database->getCity($city);
    echo json_encode($response);		
?>
