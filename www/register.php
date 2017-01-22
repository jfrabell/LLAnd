<?php
	include "Database.php";
    $database = new Database;

	$name = $_POST["firstName"];
	$lastName = $_POST["lastName"];
    $username = $_POST["username"];
    $password = $_POST["password"];
	$password = md5($password);
	$email = $_POST["email"];

	$response = array();
	$response["success"] = false;  
	$response = $database->register($username,$password,$name,$lastName,$email);

    echo json_encode($response);


?>