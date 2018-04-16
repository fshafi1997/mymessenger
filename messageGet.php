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

$username = stripslashes(htmlspecialchars($_GET['username']));
echo "$username";
echo "<br>";


// get all from messages
$result = $db->prepare("SELECT * FROM messages");
$result->execute();

?>