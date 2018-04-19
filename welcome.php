<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login (index) page
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("location: index.php");
    exit;
}
?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="UTF-8">
    <title>My Messenger</title>
    <style type="text/css">
        html {
            height: 100%;
        }

        body {
            margin: 0px;
            padding: 0px;
            height: 100%;
            font-family: Helvetica, Arial, Sans-serif;
            font-size: 14px;
        }

        .msg-container {
            width: 100%;
            height: 100%;
        }

        .header {
            width: 100%;
            height: 30px;
            border-style: solid;
            border-size: 2px;
            border-color: #0a2e68;
            text-align: center;
            padding: 15px 0px 5px;
            font-size: 20px;
            font-weight: normal;
        }

        .msg-area {
            height: calc(100% - 110px);
            width: 100%;
            background-color: #FFF;
            overflow-y: scroll;
        }

        .msginput {
            padding: 5px;
            margin: 10px;
            font-size: 14px;
            width: calc(100% - 20px);
            outline: none;
        }

        .bottom {
            width: 100%;
            height: 50px;
            position: fixed;
            bottom: 0px;
            border-style: solid;
            border-size: 2px;
            border-color: #0a2e68;
            background-color: #EBEBEB;
        }

        #whitebg {
            width: 100%;
            height: 100%;
            background-color: #FFF;
            overflow-y: scroll;
            opacity: 0.6;
            display: none;
            position: absolute;
            top: 0px;
            z-index: 1000;
        }

        #loginbox {
            width: 600px;
            height: 350px;
            border: 1px solid #CCC;
            background-color: #FFF;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1001;
            display: none;
        }

        h1 {
            padding: 0px;
            margin: 20px 0px 0px 0px;
            text-align: center;
            font-weight: normal;
        }

        button {
            background-color: #43ACEC;
            border: none;
            color: #FFF;
            font-size: 16px;
            margin: 0px auto;
            width: 150px;
        }

        .buttonp {
            width: 150px;
            margin: 0px auto;
        }

        .buttonLogout {
            background-color: #1f4687;
            border: none;
            color: white;
            padding: 8px 15px;
            text-align: center;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
        }

        .buttonLogout:hover {
            background-color: red;
        }

        .msg {
            border-radius: 10px;
            margin: 10px 10px;
            background-color: #f1f0f0;
            max-width: calc(45% - 20px);
            color: #000;
            padding: 10px;
            font-size: 14px;
        }

        .msgfrom {
            border-radius: 10px;
            background-color: #0084ff;
            color: #FFF;
            margin: 10px 10px 10px 55%;
        }

        .msgarr {
            border-radius: 10px;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid #f1f0f0;
            transform: rotate(315deg);
            margin: -12px 0px 0px 45px;
        }

        .msgarrfrom {
            border-radius: 10px;
            border-bottom: 8px solid #0084ff;
            float: right;
            margin-right: 45px;
        }

        .msgsentby {
            border-radius: 10px;
            color: #8C8C8C;
            font-size: 12px;
            margin: 4px 0px 0px 10px;
        }

        .msgsentbyfrom {
            border-radius: 10px;
            float: right;
            margin-right: 12px;
        }
    </style>
</head>
<body onload="checkcookie(); update();">
<div id="whitebg"></div>
<div id="loginbox">
    <h1>Pick a username for the chat:</h1>
    <p><input type="text" name="pickusername" id="cusername"
              placeholder="Pick a username for the chat" class="msginput" onblur="check(this.value)"></p>
              <span id="errorname">    </span>
    <p class="buttonp">
        <button onclick="chooseusername()">Choose Username</button>
    </p>
</div>
<div class="msg-container">
    <div style="background-color:#607faf; overflow: auto;" class="header">
        Hi, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. Welcome to my messenger.
        <a href="logout.php">
            <button class="buttonLogout">Sign out</button>
        </a>
    </div>
    <div class="msg-area" id="msg-area"></div>
    <div style="background-color:#607faf; overflow: auto;" class="bottom"><input type="text"
                                                                                 name="msginput"
                                                                                 class="msginput"
                                                                                 id="msginput"
                                                                                 onkeydown="if (event.keyCode == 13) sendmsg()"
                                                                                 value=""
                                                                                 placeholder="Enter your message here ... (Press return to send the message)">
    </div>
</div>

<script type="text/javascript">

    // the area for message entry saving in this variable
    var msginput = document.getElementById("msginput");
    var msgarea = document.getElementById("msg-area");


    function chooseusername() {
        // storing the username chosen by the user
        var user = document.getElementById("cusername").value;
        // setting the cookie so dosen't ask for again

        if (user) {
            var user = "messengerUname=" + user;
            checkUserExist(user);
            /*document.cookie = "messengerUname=" + user;
            checkcookie();*/
        } else {
            showlogin();
        }
    }

    function check(value) {
        if(value.trim()=="") {
            document.getElementById('errorname').innerHTML="Can not pick empty username";  
        }    
    }

    function checkUserExist(value) {
        var myCookie = getcookie(value);

        if (myCookie == null) {
            // do cookie doesn't exist stuff;
            document.cookie = value;
            checkcookie();
        }
        else {
            // do cookie exists stuff
            checkUname(value);
            showlogin();
        }
    }

    function checkUname(value) {
        if(value.trim()=="") {
            document.getElementById('errorname').innerHTML="User name already active in chat pick something else";  
        }    
    }

    // login show method
    function showlogin() {
        document.getElementById("whitebg").style.display = "inline-block";
        document.getElementById("loginbox").style.display = "inline-block";
    }

    // login hide method
    function hideLogin() {
        document.getElementById("whitebg").style.display = "none";
        document.getElementById("loginbox").style.display = "none";
    }

    // checking if the cookie is set then showing or hiding the choose username for chat
    function checkcookie() {
        if (document.cookie.indexOf("messengerUname") == -1) {
            showlogin();
        } else {
            hideLogin();
        }
    }

    // method to get the cookie
    function getcookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }

    // method to update the messages
    function update() {
        var xmlhttp = new XMLHttpRequest();
        var username = getcookie("messengerUname");
        // output of all the messages
        var output = "";

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // splitting individual messages
                var response = xmlhttp.responseText.split("\n")
                // number messages retrieved from db
                var rl = response.length
                var item = "";
                for (var i = 0; i < rl; i++) {
                    // splitting username and message
                    item = response[i].split("\\")
                    // undefined is blank message
                    if (item[1] != undefined) {
                        // show blue message else show grey
                        if (item[0] == username) {
                            output += "<div class=\"msgc\" style=\"margin-bottom: 30px;\"> <div class=\"msg msgfrom\">" + item[1] + "</div> <div class=\"msgarr msgarrfrom\"></div> <div class=\"msgsentby msgsentbyfrom\">Sent by " + item[0] + "</div> </div>";
                        } else {
                            output += "<div class=\"msgc\"> <div class=\"msg\">" + item[1] + "</div> <div class=\"msgarr\"></div> <div class=\"msgsentby\">Sent by " + item[0] + "</div> </div>";
                        }
                    }
                }

                // filling screen with the messages
                msgarea.innerHTML = output;
                // if scrolling the auto keep at bottom
                msgarea.scrollTop = msgarea.scrollHeight;

            }
        }
        xmlhttp.open("GET", "messageGet.php?username=" + username, true);
        xmlhttp.send();
    }

    // method to send the messages
    function sendmsg() {
        var message = msginput.value;

        // not allowing blank messages to go in database
        // every message needs the username and the message itself
        if (message != "") {

            var username = getcookie("messengerUname");

            // creating the ajax request
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function () {
                // this code will run when we send the request and get the response from the server
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    // the message and its formatting appended to the message area
                    msgarea.innerHTML += "<div class=\"msgc\" style=\"margin-bottom: 30px;\"> <div class=\"msg msgfrom\">" + message + "</div> <div class=\"msgarr msgarrfrom\"></div> <div class=\"msgsentby msgsentbyfrom\">Sent by " + username + "</div> </div>";
                    msginput.value = "";
                }
            }

            // sending the request
            // param1 = type of request param2 = address of page to open
            // passing the username and message in param 2
            xmlhttp.open("GET", "messageUpdate.php?username=" + username + "&message=" + message, true);
            xmlhttp.send();
        }

    }

    // for auto updating
    setInterval(function () {
        update()
    }, 1500);
</script>
</body>
</html>