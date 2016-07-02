<?php
    include "Database.php";
    $database = new Database;
    $username = str_replace("_", " " , $_GET["username"]);
	$adduser = str_replace("_"," " , $_GET["name"]);		
	$returnFromDB = $database->addAFriend($username , $adduser);
    echo json_encode($returnFromDB);
?>