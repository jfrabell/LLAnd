<?php
session_start();
$token = $_SESSION["token"];
if($token == "8675309"){
	    include "password.php";
		$connect = mysqli_connect("localhost", "jefffrabell", $password, "locallandings");
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else{
			$city = $_POST["city"];
			$deal = $_POST["dealtext"];
			$statement = "SELECT * FROM `locallandings`.`deals` ORDER BY `city`,`id`";
			$result = mysqli_query($connect, $statement);
			    echo "<h3>Choose a deal to edit</h3>";
			    echo "<table border=1 cellpadding=1 cellspacing=1>";
			while($myrow = mysqli_fetch_assoc($result)){
				echo "<tr><td><a href=editadeal.php?id=$myrow[id]>Edit</a></td><td>$myrow[city]</td><td>$myrow[deal]</td></tr>";
			}
			echo "</table>";
		}
		
} else {
	echo "Not authorized";
}
?>