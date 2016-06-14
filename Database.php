<?php
Class Database
{
	function __construct() {
    include "password.php";
    $this->connect = mysqli_connect("localhost", "jefffrabell", $password, "locallandings");
	
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
   }


	function register($username,$passWOrd,$firstname,$lastname,$email){   
//somewhat reconstructed, 
//need to check existing usernames

		$statement = "INSERT INTO `locallandings`.`users` (`id`, `userName`, `passWord`, `firstName`, `lastName`, `email`, `lastLogin`, `overnight`, `overnightDate`, `privacy`, `friendsWith`) VALUES (NULL, '$username', '$passWOrd', '$firstname', '$lastname', '$email', '', '', '', '', '');";
	    $response = array();	
		$response["success"]=false;

		if(!mysqli_query($this->connect,$statement)){
//			echo("Error description: " . mysqli_error($this->connect));
//			echo "<P>$statement";
			$response["success"] = false;
		}
		else {
//			echo "query workded";
			$response["success"]=true;
		}
		mysqli_close($this->connect);
		return $response;
	}
	
	function login($username,$password){		$statement = "SELECT * FROM `locallandings`.`users` WHERE `userName` = '$username'";
//login still needs last login in database
	    $response = array();	
		$response["success"]=false;
		if(!$result = mysqli_query($this->connect,$statement)){
//			echo("Error description: " . mysqli_error($this->connect));
//			echo "<P>$statement";
			$response["success"] = false;
		}
		else {
//			echo "query workded";
//			$response["success"]=true;
			while ($arow = mysqli_fetch_assoc($result))
		{
			if ($arow[passWord] == md5($password))
		    {
			$response["firstName"]= $arow[firstName];
			$response["lastName"]= $arow[lastName];
			$response["success"]= true;
			}
			else {
				$response["reason"] = "Invalid Username or Password";
			}
		}
		}
		
		mysqli_close($this->connect);
		return $response;
	}
	
	function checkin($username,$overnight){
//check in still needs date time in database
		$statement = "UPDATE `locallandings`.`users` SET `overnight` = '$overnight' WHERE `userName` = '$username'";
	    $response = array();	
		$response["success"]=false;
		
		if(!$result = mysqli_query($this->connect,$statement)){
			echo("Error description: " . mysqli_error($this->connect));
			echo "<P>$statement";
			$response["success"] = false;
		}
		else {
			$response["success"]=true;
			}
		
	return $response;
	}
	
	function getFriends($username){
		
	}	
	
}
