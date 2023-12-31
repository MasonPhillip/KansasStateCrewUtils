<?php
//inserts a video to the db and posts to a discord webhook to notify the team of the comment
//use db conn
include_once('../databaseCreds.php');
session_start();
//get the webhook
$query = "SELECT * from teams where ID = ".$_SESSION["teamId"];
$discordURL = $conn->query($query)->fetch_assoc()["webhook"];

//insert the comment to the db
$query = "INSERT INTO comments(userID, videoID, comment) VALUES (".$_SESSION["userId"].", ".$_POST["videoID"].", '".htmlspecialchars($_POST["comment"])."');";
$conn->query($query);

//update the last comment date
$query = "UPDATE videos SET lastCommentDate = NOW() WHERE ID=".$_POST["videoID"];
$conn->query($query);

//create the message\
//get the user's name for the message
$query = "SELECT name FROM users WHERE ID=".$_SESSION["userId"];
$name = $conn->query($query)->fetch_assoc()["name"];
//get the video title
$query = "SELECT videoTitle FROM videos WHERE ID=".$_POST["videoID"];
$title = $conn->query($query)->fetch_assoc()["videoTitle"];
$msgContent = $name." added a comment on ".$title.": \n".$_POST["comment"];
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

echo "Comment Added";
?>