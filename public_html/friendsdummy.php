<?php
    include "Database.php";
    $database = new Database;
    $tacocat = str_replace("_", " " , $_GET["search"]);		
	$returnFromDB = $database->searchForFriends($tacocat);
    echo json_encode($returnFromDB);
?>