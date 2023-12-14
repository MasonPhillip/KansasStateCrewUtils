<?php
//ensures the name is not already in use and that the team code exists
$servername = "localhost:3306";
$username = "i9673948_wp1";
$password = "abc12345";
$dbname = "i9673948_wp1";
$conn = mysqli_connect($servername, $username, $password, $dbname);

//initialize the response
$response = "";

//validate the team code exists
$query = "SELECT * FROM teams where code='".htmlspecialchars($_POST["team"])."'";
$result = $conn->query($query);
if(mysqli_num_rows($result) > 0){
    $response = $result->fetch_assoc()["ID"]."|";
}
else{
    $response = "Team Not Found|";
}

//ensure the username is not in use
$query = "SELECT * FROM users WHERE name='".htmlspecialchars($_POST["name"])."'";
$result = $conn->query($query);
if(mysqli_num_rows($result) > 0){
    $response = $response."name in use";
}
else{
    $response = $response."name not found";
}

echo $response;


?>