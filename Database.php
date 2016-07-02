<?php
Class Database {
	function __construct() {
		include "password.php";
		$this -> connect = mysqli_connect("localhost", "jefffrabell", $password, "locallandings");

		// Check connection
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	}

	function register($username, $passWOrd, $firstname, $lastname, $email) {
		//somewhat reconstructed,
		//need to check existing usernames

		$statement = "INSERT INTO `locallandings`.`users` (`id`, `userName`, `passWord`, `firstName`, `lastName`, `email`, `lastLogin`, `overnight`, `overnightDate`, `privacy`, `friendsWith`) VALUES (NULL, '$username', '$passWOrd', '$firstname', '$lastname', '$email', '', '', '', '', '');";
		$response = array();
		$response["success"] = false;

		if (!mysqli_query($this -> connect, $statement)) {
			//			echo("Error description: " . mysqli_error($this->connect));
			//			echo "<P>$statement";
			$response["success"] = false;
		} else {
			//			echo "query workded";
			$response["success"] = true;
		}
		mysqli_close($this -> connect);
		return $response;
	}

	function login($username, $password) {		$statement = "SELECT * FROM `locallandings`.`users` WHERE `userName` = '$username'";
		//login still needs last login in database
		$response = array();
		$response["success"] = false;
		if (!$result = mysqli_query($this -> connect, $statement)) {
			//			echo("Error description: " . mysqli_error($this->connect));
			//			echo "<P>$statement";
			$response["success"] = false;
		} else {
			//			echo "query workded";
			//			$response["success"]=true;
			while ($arow = mysqli_fetch_assoc($result)) {
				if ($arow[passWord] == md5($password)) {
					$response["firstName"] = $arow[firstName];
					$response["lastName"] = $arow[lastName];
					$response["success"] = true;
				} else {
					$response["reason"] = "Invalid Username or Password";
				}
			}
		}

		//set login time
		$now = time();
		$timeStatement = "UPDATE `locallandings`.`users` SET `lastLogin` = '$now' WHERE `userName` = '$username'";
		mysqli_query($this -> connect, $timeStatement);
		mysqli_close($this -> connect);
		return $response;
	}

	function checkin($username, $overnight) {
		//check in still needs date time in database
		$now = time();
		$overnight = str_replace("_", " ", $overnight);
		mysqli_query($this -> connect, $timeStatement);
		$statement = "UPDATE `locallandings`.`users` SET `overnight` = '$overnight' , `overnightDate` = '$now' WHERE `userName` = '$username'";
		$response = array();
		$response["success"] = false;
		$result = mysqli_query($this -> connect, $statement);
		if (mysqli_affected_rows($this -> connect) == 0) {
			echo mysqli_affected_rows($result);
			echo "Error description: No Rows Affected";
			echo "<P>$statement";
			$response["success"] = false;
		} else {
			$response["success"] = true;
		}

		return $response;
	}

	function getFriends($username) {
		//returns a string of text about each friend's checkin
		$statement = "SELECT * FROM `locallandings`.`users` WHERE `userName` = '$username'";
		$response = array();
		$response["success"] = false;

		if (!$result = mysqli_query($this -> connect, $statement)) {
			echo("Error description: " . mysqli_error($this -> connect));
			echo "<P>$statement";
			$response["success"] = false;
		} else {
			$response["success"] = true;

			//we have the row, now get the friends
			$arow = mysqli_fetch_assoc($result);
			$friendList = explode("|", $arow['friendsWith']);

			//now get names and locations

			$tempStatement = "SELECT * FROM `locallandings`.`users` ORDER BY  `users`.`overnightDate` DESC";
			$tempResult = mysqli_query($this -> connect, $tempStatement);
			$i = 0;
			while ($tempRow = mysqli_fetch_assoc($tempResult)) {
				if (in_array($tempRow['id'], $friendList)) {
					$tempName = $tempRow['firstName'] . " " . $tempRow['lastName'];
					$tempLocation = $tempRow['overnight'];
					$tempDate = date("m-d-y", $tempRow['overnightDate']);
					$response["friend$i"] = "$tempName checked in at $tempLocation on $tempDate";
					$i++;
				}
			}
			$i = 0;
		}

		return $response;
	}

	function searchForFriends($searchString) {
		$position = strpos($searchString, " ");
		if ($position === false) {
			$firstNameSearched = $searchString;
			$lastNameSearched = $searchString;
		} else {
			$searchStringArray = explode(" ", $searchString);
			$firstNameSearched = $searchStringArray[0];
			$lastNameSearched = $searchStringArray[1];
		}
		$statement = "SELECT * FROM `locallandings`.`users` WHERE `userName` LIKE '%$searchString%' OR `firstName` LIKE '%$firstNameSearched%' OR `lastName` LIKE '%$lastNameSearched%'";
		$response = array();
		$response["success"] = false;

		if (!$result = mysqli_query($this -> connect, $statement)) {
			echo("Error description: " . mysqli_error($this -> connect));
			echo "<P>$statement";
			$response["success"] = false;
		} else {
			while ($myrow = mysqli_fetch_array($result)) {
				$response["username"] = $myrow[1];
				$response["name"] = $myrow[3] . " " . $myrow[4];
			}
			if ($response["username"] != "")
				$response["success"] = "true";
			else {
				$response["success"] = "false";
			}
		}
		return $response;
	}

	function addAFriend($username, $addFriendName) {
		$response["success"] = "false";
//get list of friends
		$statement = "SELECT * FROM `locallandings`.`users` WHERE `userName` = '$username'";
		if (!$dbresult = mysqli_query($this -> connect, $statement)) {
			echo("Error 175 description: " . mysqli_error($this -> connect));
			$response["success"] = "false";
			$response["reason"] = "Couldn't find current user's id";
		} else {
			while ($myrow = mysqli_fetch_assoc($dbresult)) {
				$friendsList = $myrow["friendsWith"];
			}
		}
		//explode list
		$friendsListArray = explode("|", $friendsList);
		//get id of new friend
		$statementb = "SELECT * FROM `locallandings`.`users` WHERE `userName` = '$addFriendName'";
		if (!$dbresult = mysqli_query($this -> connect, $statementb)) {
			echo("Error 188 descritption: " . mysqli_error($this -> connect));
			$response["success"] = "false";
			$response["reason"] = "Couldn't find new friend id";
		} else {
			while ($myrow = mysqli_fetch_assoc($dbresult)) {
				$newFriendId = $myrow[id];		
		//make sure we're not already friends
		$needle = $newFriendId;
		$haystack = $friendsListArray;
		if (in_array($newFriendId, $friendsListArray)) {
			//we're already friends
			$response["success"] = "false";
			$response["reason"] = "Already Friends";
		} else {
			//add id of new friend
			$friendsListArray[] = $newFriendId;
			//sort the updated list of friends
			sort($friendsListArray, SORT_NUMERIC);
			foreach ($friendsListArray as $key => $value) {
					$newListOfFriends .= "|" . $value;
			}			
			//put sorted list back in database
			$newListOfFriends = ltrim($newListOfFriends, '|');
			$statementc = "UPDATE `locallandings`.`users` SET `friendsWith` = '$newListOfFriends' WHERE `userName` = '$username'";
			if (!$result = mysqli_query($this -> connect, $statementc)) {
				echo("Error 225 descritption: " . mysqli_error($this -> connect));
				$response["success"] = "false";
				$response["reason"] = "Couldn't add new list to database";
			} else {
				$response["success"] = "true";
				$response["query"] = $statementc;
			}}}}
		return $response;
		
	}

}
