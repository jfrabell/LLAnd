<?php

$userName = $_GET['username'];

$path = "ProfilePhotos";

$imagePath = "$path/$userName".".jpg";

$response["success"] = "true";


        $im = file_get_contents($imagePath);
        $imdata = base64_encode($im);      
		$encoded_data = base64_encode(file_get_contents($imagePath));  


$file = fopen($imagePath);
$response["path"] = $imagePath;
$response["image"] = $encoded_data;

echo json_encode($response);
?>
