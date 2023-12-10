<?php
//inserts a video to the db and posts to a discord webhook to notify the team of the comment
$servername = "localhost:3306";
$username = "i9673948_wp1";
$password = "abc12345";
$dbname = "i9673948_wp1";
$conn = mysqli_connect($servername, $username, $password, $dbname);

$query = "INSERT INTO users (name, discordHandle, password, teamID) VALUES ('".htmlspecialchars($_POST["nameBox"])."', '".htmlspecialchars($_POST["discordBox"])."', '".htmlspecialchars($_POST["passwordBox"])."', ".$_POST["teamBox"].");";
$conn->query($query);
?>

<html>
    <head>
        
    </head>
    <body>
        
    </body>

    <script>
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