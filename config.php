<?php
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect("localhost:3306","fshafi","y92Sle6&","fshafi_messages");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>