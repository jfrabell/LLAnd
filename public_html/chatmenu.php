<?php
//set up database
include "password.php";
$connect = mysqli_connect("localhost", "jefffrabell", $password, "locallandings");

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Get data from app
$username = $_GET["username"];
$city = $_GET["city"];

$response = array();
$response["success"] = false;

//build query
$statement = "SELECT * FROM `locallandings`.`aa_messages` WHERE `to` = '$username' or `to` = '$city' ORDER BY `date` desc";
//execute query

$result = mysqli_query($connect, $statement);
if ($result) {

	$response["success"] = "true";
	$cityMessagePresent = false;
	$alreadyStoredCityMessage = false;
	//create array of senders 1st should be City
	while ($myrow = mysqli_fetch_assoc($result)) {
			 " To " . $myrow["to"] .
			 " Message " . $myrow["text"] .
			 "<br>";
		if ($myrow["to"] == $city) {
			$cityMessagePresent = true;
			if ($alreadyStoredCityMessage) {
				//do nothing
			} else {
				if($myrow["to"]==$city){
				$message_to_city = $myrow["text"];
				$alreadyStoredCityMessage = true;}
			}
		} else {
			$testvar = $myrow["from"];
			if (in_array($testvar, $senders)) {
			} else {
				$senders[] = $myrow["from"];
				$messages[] = $myrow["text"];
			}
		}
	}
} else {
	$response["success"] = "false";
	$response["query"] = $statement;
}

//finish database connection
mysqli_close($connect);
array_splice($senders, 0, 0, $city);

if (empty($messages)) {
}
else{
	if($alreadyStoredCityMessage)
array_splice($messages, 0, 0, $message_to_city);
	else {
		array_splice($messages,0,0,"No messages in this city");
	}
}
//number of senders
$numberOfSenders = count($senders);
if ($numberOfSenders == 0) {
	$response["sender0"] = $city;
	$response["message0"] = $message_to_city;
}
//set names
for ($i = 0; $i < $numberOfSenders; $i++) {
	$response["sender" . $i] = $senders[$i];
	$response["message" . $i] = $messages[$i];
}

echo json_encode($response);

//	$numberOfRecords = (count($response) - 1)/4;
//	echo "<p>$numberOfRecords";
?>
