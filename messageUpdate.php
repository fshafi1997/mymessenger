
<?php
/*param1=db host
param2=username
param3=password
param4=db name*/
$db = new mysqli("localhost","fshafi","y92Sle6&","fshafi_messages");

if($db->connect_error){
    die("Was unable to connect to database". $db->connect_error);
}
else echo "connected to the data base";

// whatever set in environment variable will come here
// using htmlspecialchars to prevent users from putting tags in url
// strip slashes used to clean up data remove  \
$username = $_GET['username'];
echo $username;
//$message = stripslashes(htmlspecialchars($_GET['message']));

/*
// if username or message is empty exit current script
if ($message == "" || $username == "") {
	die();
}

// insert the message into the data base
// 1st value id(auto incremented) 2nd value (username) 3rd value (message)
$result = $db->prepare("INSERT INTO messages VALUES('',?,?)");
// substituting the question mark "ss" for string username and string message
$result->bind_param("ss", $username, $message);
echo "username is $username\n";
echo "message is $message\n";
$result->execute();


$sql = "INSERT INTO messages (id, username, message) VALUES ('', $username, $message)";

if ($db->query($sql) === TRUE) {
    echo "New record created successfully\n";
    echo "username is $username\n";
    echo "message is $message\n";
} else {
    echo "Error: " . $db . "<br>" . $db->error;
}

$db->close();*/

?>