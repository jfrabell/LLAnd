<?php
session_start();
$token = $_SESSION["token"];
if($token == "8675309"){
    include "password.php";	
	$connect = mysqli_connect("localhost", "jefffrabell", $password, "locallandings");
	
	$submit = $_GET[submit];
	if($submit == "Submit Changes")
	{
		$city = $_GET[city];
		$deal = $_GET[deal];
		$id = $_GET[id];
		$statement = "UPDATE `locallandings`.`deals` SET `city` = '$city' , `deal` = '$deal' WHERE `id` = '$id'";
		$result = mysqli_query($connect, $statement);
		if($result){
			echo "Deal Updated<p><a href=editdeals.php>Edit another?</a><br><a href=home.php>Home</a>";
		}
		else{
			echo "Fail";
		}
	}
	else {
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else{
			$id = $_GET["id"];
			$statement = "SELECT * FROM `locallandings`.`deals` WHERE `id` = '$id'";
			$result = mysqli_query($connect, $statement);
			    echo "<h3>Editing Deal</h3>";
				echo "<form action = editadeal.php method=GET>";
			    echo "<table border=1 cellpadding=1 cellspacing=1>";
				echo "<tr><th>City</th><th>Deal</th></tr>";
			while($myrow = mysqli_fetch_assoc($result)){
				echo "<tr><td><input type=text name='city' id='city' value='$myrow[city]'></td><td><input type=text name='deal' id='deal' value='$myrow[deal]'></td></tr>";
			}
			echo "<tr><td colspan=2 align=center><input type=hidden name=id value='$id'><input type=submit name='submit' value='Submit Changes'></td></tr>";
			echo "</table></form>";
		}
		
	}
		
} else {
	echo "Not authorized";
}
?>