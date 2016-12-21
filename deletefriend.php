<?php
    include "Database.php";
    $database = new Database;
	$deleteuser = str_replace("_"," " , $_GET["name"]);		
	$username = $_GET["username"];
	$returnFromDB = $database->deleteAFriend($username , $deleteuser);
    echo json_encode($returnFromDB);
?>