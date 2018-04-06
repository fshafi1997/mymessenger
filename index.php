<?php

<!--
param1=db host
param2=username
param3=password
param4=db name-->

$db = new mysqli("localhost","fshafi","y92Sle6&","fshafi_messages");

if($db->connect_error){
    die("Was unable to connect to database");
} else {
    die("Connection to database was successfull");
}