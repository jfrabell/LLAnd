<?php
    include "Database.php";
    $database = new Database;
    $username = str_replace("_", " " , $_REQUEST["user"]);
	$returnFromDB = $database->getFriendsNameOnly($username);
    echo json_encode($returnFromDB);
?>