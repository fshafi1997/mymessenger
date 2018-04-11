
<?php
/*param1=db host
param2=username
param3=password
param4=db name*/
$db = new mysqli("localhost:3306","fshafi","y92Sle6&","fshafi_messages");

if($db->connect_error){
    die("Was unable to connect to database". $db->connect_error);
}
else echo "Connected successfully";

echo "<br>";

// whatever set in environment variable will come here
// using htmlspecialchars to prevent users from putting tags in url
// strip slashes used to clean up data remove  \
$username = $_GET['username'];
echo "$username";
echo "<br>";
$message = $_GET['message'];
echo "$message";
echo "<br>";



// if username or message is empty exit current script
if ($message == "" || $username == "") {
	die();
}

$sql = "INSERT INTO messages (id, username, message) VALUES (DEFAULT,'$username','$message')";

$retval = mysql_query( $sql, $db );

if($retval) {
    echo "Success";
    echo "username going in data base is $username";
    echo "<br>";
    echo "message going in data base is $message";
    echo "<br>";
} else {
    echo "Error";
}

/*
// insert the message into the data base
// 1st value id(auto incremented) 2nd value (username) 3rd value (message)
$result = $db->prepare("INSERT INTO messages VALUES(DEFAULT,?,?)");
// substituting the question mark "ss" for string username and string message
$result->bind_param("ss", $username, $message);
echo "username going in data base is $username";
echo "";
echo "message going in data base is $message";
echo "";
$result->execute();*/

?>