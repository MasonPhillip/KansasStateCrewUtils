<?php
//inserts a video to the db and posts to a discord webhook to notify the team of the comment

//use db conn
include_once('../databaseCreds.php');

//insert the values into users
$query = "INSERT INTO users (name, discordHandle, password, teamID) VALUES ('".htmlspecialchars($_POST["nameBox"])."', '".htmlspecialchars($_POST["discordBox"])."', '".htmlspecialchars($_POST["passwordBox"])."', ".$_POST["teamBox"].");";
$conn->query($query);
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
		var userId = document.createElement('input');
		userId.type='hidden';
		userId.setAttribute("name", "userId");
		userId.setAttribute("id", "userId");
		userId.setAttribute("value", '<?php echo $conn->insert_id;?>');
		form.appendChild(userId);
		document.body.appendChild(form);
		form.submit();
        
    </script>
</html>