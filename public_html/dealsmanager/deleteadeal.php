<?php
session_start();
$token = $_SESSION["token"];
if($token == "8675309"){
    include "password.php";	
	$connect = mysqli_connect("localhost", "jefffrabell", $password, "locallandings");
	
	$submit = $_GET[submit];
	if($submit == "Keep It")
	{
		echo "No Changes Made";	
	}
	elseif($submit == "Delete It"){
		$id = $_GET[id];
		$statement = "DELETE FROM `locallandings`.`deals` WHERE `id` = '$id' LIMIT 1";
		$result = mysqli_query($connect, $statement);
		if($result){
			echo "Deal Deleted<p><a href=deletedeals.php>Delete another?</a><br><a href=home.php>Home</a>";
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
			    echo "<h3>Are You sure you want to delete this deal?</h3>";
				echo "<form action = deleteadeal.php method=GET>";
			    echo "<table border=1 cellpadding=1 cellspacing=1>";
				echo "<tr><th>City</th><th>Deal</th></tr>";
			while($myrow = mysqli_fetch_assoc($result)){
				echo "<tr><td>$myrow[city]</td><td>$myrow[deal]</td></tr>";
			}
			echo "<tr><td align=center colspan=2><input type=submit name='submit' value='Keep It'> or <input type=hidden name=id value='$id'><input type=submit name='submit' value='Delete It'></td></tr>";
			echo "</table></form>";
		}
		
	}
		
} else {
	echo "Not authorized";
}
?>