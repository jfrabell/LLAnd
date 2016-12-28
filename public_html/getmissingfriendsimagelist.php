<?php
$response["success"] = "false";

//get list of friends' usernames from database
$username = $_POST["username"];
include "password.php";
		$connect = mysqli_connect("localhost", "jefffrabell", $password, "locallandings");

		// Check connection
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		$statement = "SELECT * FROM `locallandings`.`users` WHERE `userName` = '$username'";
		$result = mysqli_query($connect, $statement);
		while($myrow=mysqli_fetch_assoc($result)){
			$friends = $myrow["friendsWith"];
		}
		
		$friendsIdArray = explode("|",$friends);
		$statementB = "SELECT * FROM `locallandings`.`users`";
		$resultB = mysqli_query($connect, $statementB);
		while($myrowB = mysqli_fetch_assoc($resultB)){
			$needle = $myrowB["id"];
			$haystack = $friendsIdArray;
			if(in_array($needle, $haystack)){
							if($userNamesNeeded == "")
							$userNamesNeeded = $myrowB["userName"];
							else
							$userNamesNeeded .= "|".$myrowB["userName"];
			}
		}


if ($userNamesNeeded == ""){
	$response["reason"] = "No pictures needed";
}
else{
$missingUserNames = explode("|", $userNamesNeeded);

$finalNumber = count($missingUserNames);

for ($i = 0; $i <= $finalNumber; $i++) {
	$key = $missingUserNames[$i];
	$sqlImage = "SELECT * FROM `locallandings`.`aa_photo` WHERE `userID` = '$key'";
	$resultC = mysqli_query($connect, $sqlImage);
	while($myrowImage = mysqli_fetch_assoc($resultC)){
	$imageList.=$myrowImage[photoName]."|";
	$response["success"] = "true";
	}
}

$response["images"] = rtrim($imageList, "|");


for($i=0; $i<10; $i++){
	
}


}

echo json_encode($response);	

?>
