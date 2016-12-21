<?php
session_start();
$token = $_SESSION["token"];
if($token == "8675309"){
echo "<h3>Deals Management</h3>";
echo "<a href=adddeals.php>Add Deals</a><br>";
echo "<a href=editdeals.php>Edit Deals</a><br>";
echo "<a href=deletedeals.php>Delete Deals</a>";
}
else{
	echo "Not authorized";
}



?>