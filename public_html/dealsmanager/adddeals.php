<?php
session_start();
$token = $_SESSION["token"];
if($token == "8675309"){
	if($_POST["submit"] == "Submit"){
		include "password.php";
		$connect = mysqli_connect("localhost", "jefffrabell", "$password", "locallandings");
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else{
			$city = $_POST["city"];
			$deal = $_POST["dealtext"];
			$statement = "INSERT INTO `locallandings`.`deals` (`id`, `city`, `deal`, `image`) VALUES (NULL, '$city', '$deal', '')";
			if (!mysqli_query($connect, $statement)) {
				echo "<p>$statement is statement";
				echo("Error description: " . mysqli_error($connect));
		} else {
			echo "Deal Added.<p><a href=adddeals.php>Add Another?</a><br><a href=home.php>Home</a>";
		}
		}
	} else {
	
?>	
<form action=adddeals.php method=POST>
<table border=1 cellpadding=0 cellspacing=0>	
	<tr>
		<td>
			City:
		</td>
		<td>
			<input type=text name="city" id="city">		
		</td>
	</tr>
 	<tr>
 		<td>
 			Deal Text:
 		</td>
 		<td>
			<input type=text id="dealtext" name="dealtext"> 			
 		</td>
 	</tr>
 	<tr>
 		<td colspan=2 align="center">
			<input type=submit name="submit" value="Submit" id="submit"> 			
 		</td>
 	</tr>
</table>
</form>
<?php
	}
} else {
	echo "Not authorized";
}
?>