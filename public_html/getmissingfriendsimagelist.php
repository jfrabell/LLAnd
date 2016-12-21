<?php
$response["success"] = "false";

//get list of friends' usernames from database
$username = $_GET["username"];
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



$path = "./ProfilePhotos";

if ($userNamesNeeded == ""){
	$response["reason"] = "No pictures needed";
}
else{
$missingUserNames = explode("|", $userNamesNeeded);


for($j=0; $j<count($missingUserNames); $j++){
$filenames = scandir($path);

foreach($filenames as $afile) {
	$testString = $missingUserNames[$j];
	$testFileName = explode(".",$afile);
	
if($testString == $testFileName[0]) 
{
	if($stringfilelist == ""){
			$stringfilelist .= "$afile";		
	}
	else{
			$stringfilelist .= "|$afile";
	}
}
    
}

}

$filelist = explode("|",$stringfilelist);
$tester = $filelist["0"];
if($tester === ""){
	$response["reason"] = "No Friends with pictures";	
}
else{
	$response["success"] = "true";
	for($q=0; $q < count($filelist); $q++){
		$response["file$q"] = $filelist[$q];
	}
	
}
}  // end of case where no pics are needed


echo json_encode($response);	

?>
