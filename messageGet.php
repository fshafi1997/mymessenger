<!DOCTYPE html>
<html lang="en">
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8">
        <title>CS252 Lab-6</title>
    </head>
    <body>
        <p>Testing if the database is connected<br />
            <?php
            /*param1=db host
            param2=username
            param3=password
            param4=db name*/
            $db = new mysqli("localhost","fshafi","y92Sle6&","fshafi_messages");

            if($db->connect_error){
                die("Was unable to connect to database");
            } else {
            die("Connection to database was successfull");
            }
            
            ?>
        </p>
    </body>
</html>