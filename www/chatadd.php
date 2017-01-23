<?php
        include "password.php";
		$connect = mysqli_connect("localhost", "jefffrabell", $password, "locallandings");

		// Check connection
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		$from = $_POST["from"];
		$to = $_POST["to"];
		$text = $_POST["text"];

		$text = addslashes($text);

		$response = array();
		$response["success"] = false;  
	
	
		$now = time();
		$statement = "INSERT INTO  `locallandings`.`aa_messages` (`id`,`date`,`from`,`to`,`text`) VALUES ('','$now','$from','$to','$text')";
		
		if(mysqli_query($connect, $statement))
		$response["success"] = "true";
		else {
			$response["success"] = "false";
			$response["query"] = $statement;
		}
		mysqli_close($connect);
	
	
    echo json_encode($response);


?>
