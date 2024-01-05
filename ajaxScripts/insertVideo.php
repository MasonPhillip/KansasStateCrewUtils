<?php
include_once('../databaseCreds.php');
session_start();
//insert video into vidoes table
$query = "INSERT INTO videos(url, videoTitle, createdByUserID) VALUES('".str_replace("/view?usp=sharing", "", htmlspecialchars($_POST["url"]))."', '".htmlspecialchars($_POST["title"])."' ,".htmlspecialchars($_SESSION["userId"]).");";
$conn->query($query);

//insert the first comment for the video
$last_id = $conn->insert_id;
$query = "INSERT INTO comments(userID, videoID, comment) VALUES (".htmlspecialchars($_SESSION["userId"]).", ".$last_id.", '".htmlspecialchars($_POST["comment"])."');";
$conn->query($query);

//get the webhook
$query = "SELECT webhook FROM teams WHERE ID=".$_SESSION["teamId"];
$temp = $conn->query($query)->fetch_assoc();
$discordURL = $temp["webhook"];

//create the message
$query = "SELECT name FROM users WHERE ID =  ".$_SESSION["userId"];
$temp = $conn->query($query)->fetch_assoc();
$name = $temp["name"];
$msgContent = $name." created a new video thread on this video: ".htmlspecialchars($_POST["title"])." \n".htmlspecialchars($_POST["url"]);
$msg = ["content" => $msgContent];
//send the message
$headers = array('Content-Type: application/json');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $discordURL);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode( $msg ) );
$responses = curl_exec($ch);
curl_close($ch);


?>

<body>
    <form action="../videoComments.php" method="post" id="f">
        <input type="hidden" id="videoID" name="videoID" value=<?php echo "'".$last_id."'";?>></input>
    </form>
</body>

<script>

document.getElementById("f").submit();
    
</script>

