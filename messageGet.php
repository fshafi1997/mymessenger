<?php
/*param1=db host
param2=username
param3=password
param4=db name*/
$db = new mysqli("localhost:3306","fshafi","y92Sle6&","fshafi_messages");

if($db->connect_error){
    die("Was unable to connect to database". $db->connect_error);
}

echo "<br>";

$username = stripslashes(htmlspecialchars($_GET['username']));
echo "$username";
echo "<br>";


// get all from messages
$result = $db->prepare("SELECT * FROM messages");
$result->execute();

// saving the result form database
$result = $result->get_result();

// \\ this is delimeter to make parsing easier
while ($r = $result->fetch_row()) {
    // username
    echo $r[1];
    echo "\\";
    // message
	echo $r[2];
	echo "\n";
}

?>