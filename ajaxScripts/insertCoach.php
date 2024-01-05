<?php
//inserts a video to the db and posts to a discord webhook to notify the team of the comment

//use db conn
include_once('../databaseCreds.php');

//insert the values into users
$query = "INSERT INTO users (name, discordHandle, password, teamID, isCoach) VALUES ('".htmlspecialchars($_POST["nameBox"])."', '".htmlspecialchars($_POST["discordBox"])."', '".htmlspecialchars($_POST["passwordBox"])."', ".$_POST["teamBox"].", 1);";
$conn->query($query);

$session_start();
$_SESSION["userId"] =  $conn->insert_id;
$_SESSION["teamId"] = $_POST["teamBox"];
$_SESSION["isCoach"] = 1;
?>

<html>
    <head>
        
    </head>
    <body>
        
    </body>

    <script>
    //sends the user back to the videos page
        var form = document.createElement('form');
		form.action = "/videos.php";
		form.method='POST';
		document.body.appendChild(form);
		form.submit();
        
    </script>
</html>