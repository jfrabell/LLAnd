<?php 
//the basics
    $url = 'https://fcm.googleapis.com/fcm/send';
    $key = 'AIzaSyA15OtlA5hCnuFSnIvDIlD5SNlrJfoYvrU';
    $headers = array(
       'Content-Type: application/json',
       'Authorization: key=' . $key,       
   );

//get form data   
   $from = $_POST["from"];
   $to = $_POST["to"];
   $title = $_POST["title"];
   $message = $_POST["message"];
   
//overwrite form data (remove)   
//   $from = "jfrabell";
   $to = "eWBs6WBVjF0:APA91bE3Ht8Z0R3OU6KxmWQt1SmZI9uoozt2fhF5vHr0ihHBpajpFa7g1eYf9doBEs-O1dQtp9GlFbR7GF5OlYHmmkzqTa6W6d2g_Hk2n8Pn38CKJPU1vkh7uuwJaCAtV2abYmb2m1x6";
//   $title = "Local Landings Message";
//   $message = "I think you're the best!";
   
//build the payload   
   $body = array();
   $subbody = array();
   $data = array();
   $data["username"] = $from;
   $subbody["title"] = $title;
   $subbody["text"] = $message;  
   $body["notification"] = $subbody;
   $body["data"] = $data;
   $body["to"] = $to; 
   $sendHeaders = $headers[0].$headers[1];
   $sendBody = json_encode($body);

//send it
send_curl($url, $headers, $sendBody);

function send_curl($url, $headers, $body)
{
    //GET CI 
	$ch = curl_init($url);
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   // Disabling SSL Certificate support temporarly
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

   curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

   // Execute post
   $result = curl_exec($ch);

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($http_code == 404)
{
echo "Not found";
}

   if ($result === FALSE) {
       die('Curl failed: ' . curl_error($ch));
   }
   else {
       // it worked
   }
       curl_close($ch);
}

?>