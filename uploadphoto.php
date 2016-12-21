<?php
//Still need to delete old profile photos.

include "password.php";
		$con = mysqli_connect("localhost", "jefffrabell", $password, "locallandings");

		// Check connection
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		if($_SERVER['REQUEST_METHOD']=='POST'){

 $image = $_POST['fileToUpload'];
 $name = $_POST['name'];
 $permaname = $_POST['name'];
 $userID = $_POST['userID'];
 $fileName = $_POST['fileName'];
 $fileArray = explode(".", $fileName);
 $fileExtension = $fileArray[1];
 
 $fileExtension = fixFileExtension($fileExtension);

 $sequenceNumber = addSequenceNumber($name,$password);
 $name = $permaname.$sequenceNumber;
 
 $photoName = $name.".$fileExtension";
  
 $actualpath = "ProfilePhotos/$photoName";

$sqla = "SELECT * FROM `locallandings`.`aa_photo` WHERE `userID` = '$permaname'";
$resulta = mysqli_query($con, $sqla);

$isThereARow = mysqli_num_rows($resulta);

if($isThereARow==1){
 //if it's an update
$sql = "UPDATE `locallandings`.`aa_photo` SET `photoName` = '$photoName' WHERE `aa_photo`.`userID` = '$permaname' LIMIT 1";	
}
else{ 
 //if it's a new one
$sql = "INSERT INTO `locallandings`.`aa_photo` (`id`,`userID`,`photoName`) VALUES (NULL , '$permaname','$photoName')"; 
}
  
 if(mysqli_query($con,$sql)){
file_put_contents($actualpath,base64_decode($image));
//DELETE THE OLD ONE!
 }
 
 mysqli_close($con);
 }
 
 function addSequenceNumber($userID,$password){
	 
	 $con = mysqli_connect("localhost", "jefffrabell", $password, "locallandings");

		// Check connection
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	 
	 $runner = "00000";
 $sql = "SELECT * FROM `locallandings`.`aa_photo` WHERE `userID` = '$userID'";
 $result = mysqli_query($con,$sql);
 $numRows = mysqli_num_rows($result);
 if($numRows==0){
	 $runner = "00001";
 }
 elseif($numRows==1){
     while($myrow=mysqli_fetch_assoc($result)){
	 $photoName = $myrow['photoName'];
	 $arrayPhotoName = explode(".",$photoName);
	 $photoNameLeftOfDot = $arrayPhotoName[0];
	 
	 $num = $photoNameLeftOfDot;
$num = substr($num, -5);

if($num == "00000")
$num = "00001";

$num = (int)$num;
$num +=1;

$numString = (string)$num;
$length = strlen($numString);
$shortOfFive = 5-$length;

if($shortOfFive == 5)
$finalString = "00001";
if($shortOfFive == 4)
$finalString = "0000".$numString;
if($shortOfFive == 3)
$finalString = "000".$numString;
if($shortOfFive == 2)
$finalString = "00".$numString;
if($shortOfFive == 1)
$finalString = "0".$numString;
if($shortOfFive == 0)
$finalString = $numString;


$runner = $finalString;
	 
	 }
 }
 else{
 $sqlb = "DELETE FROM `locallandings`.`aa_photo` WHERE `aa_photo`.`userID` = '$userID'";
	 $resultb = mysqli_query($con,$sqlb);
	 $runner = "00001";
 }
 return $runner;
 }
 
 function fixFileExtension($extension){
if($extension!="jpg"&&$extension!="jpeg"&&$extension!="gif"&&$extension!="pxy")
$extension = "jpg";

return $extension;	 
 }
 
?>