<?php
//init db vars
include_once('../databaseCreds.php');

//pull the entered name and password from post
$name = htmlspecialchars($_POST["name"]);
$password = htmlspecialchars($_POST["password"]);

//query the db for users and their names
$query = "SELECT * FROM users;";
$result = $conn->query($query);

//set the default xhttp response to invalid
$response = "invalid";
while($row = $result->fetch_assoc()){
	if($row["name"] == $name){
        //if the name is found set the xhttp response to valid name
        $response="validName";
        if($row["password"] == $password){
            //if the password matches and the name is found set the xhttp response to valid = the id of that row
            $response = "accepted + ".$row["ID"];
        }
    }
}

//echo response so xhttp.responseText can grab it
echo $response;


?>
