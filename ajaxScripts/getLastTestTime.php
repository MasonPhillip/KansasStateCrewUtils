<?php
    //returns None found or time|split
    include_once '../databaseCreds.php';
    include_once '../timeAndSplitConverter.php';
    $distance = $_GET["distance"];
    $userId = $_GET["userId"];
    $query = "SELECT avgSplit, time FROM workouts WHERE distance=".$distance." AND userId=".$userId." ORDER BY date DESC";
    $results = $conn->query($query);
    if(mysqli_num_rows($results) < 1){
        echo "None Found";
    }
    else{
        $result = $results->fetch_assoc();
        echo formatTime($result["time"])."|".formatTime($result["avgSplit"]);
        //echo "found";
    }
    
?>