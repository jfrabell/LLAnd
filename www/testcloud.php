<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>

<?php
$submit = $_POST['submit'];
if($submit == "Submit"){
echo "Sending";
$token = "fj9Ik5ZGi9E:APA91bF7Jc1HwfyeJXAztelzmvRAYJrmLQmpT2bZCr_URxOJJZ8KoibJJbKRcp3i-TN6o7qPGzZ5a3uAvJc8PKzuXgnek6iDkl9cHZneSOMU6IBNJ8O5rsb5ubZI5RjzBNOy4pACOo20";
$url = "https://fcm.googleapis.com/fcm/send";

//$message = "{ \"username\":\"jfrabell\" {\"score\": \"5x1\",\"time\": \"15:10\"},";
$message = "Hello?";

sendGCM($message,$token);
}
else
{
	?>
<form action="testcloud.php" method="post">
<input type="submit" name="submit" value="Submit">
<?php
}




function sendGCM($message, $id) {


    $url = 'https://fcm.googleapis.com/fcm/send';
	$username = "jfrabell";
	$other = "Other";


    $fields = array (
            'registration_ids' => array (
                    $id
            ),
            'data' => array (
                    "message" => $message,
					"username" => $username,
					"other" => $other
					
            )
    );
    $fields = json_encode ( $fields );

echo $fields ."<p>";

    $headers = array (
            'Authorization: key=' . "AAAA4MtTmvk:APA91bFaT3H_UyYvM7yQ03FKpg-v5_FRXZ0SB_DK14V9gzbqGmWhKVgXglyPkRaRD8Vzd7lINBGt2qidaKGjK1k1KKNpC8YSKLkU-1OlGr48oJ_4nixGaVd-tq2uLX99K-cQrl26lY3c",
            'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
    echo $result;
    curl_close ( $ch );
}

?>


</body>
</html>
