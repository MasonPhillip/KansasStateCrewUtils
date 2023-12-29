<?php
    include_once '../databaseCreds.php';
    $query = "INSERT INTO seasons (startDate, endDate, name, teamId) VALUES('".$_POST["startDate"]."', '".$_POST["endDate"]."', '".$_POST["name"]."', ".$_POST["teamId"].")";
    $conn->query($query);
    echo "success";
?>