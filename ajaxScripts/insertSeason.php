<?php
    include_once '../databaseCreds.php';
    session_start();
    $query = "INSERT INTO seasons (startDate, endDate, name, teamId) VALUES('".$_POST["startDate"]."', '".$_POST["endDate"]."', '".$_POST["name"]."', ".$_SESSION["teamId"].")";
    $conn->query($query);
    echo "success";
?>