<?php
    include_once ('../databaseCreds.php');
    $results = json_decode($_POST["results"], true);
    $distance = $_POST["distance"];
    $testId = $_POST["testId"];
    $title = $_POST["title"];
    for($i = 0; $i<count($results); $i++){
        if($results[$i]["time"] == 0){
            
        }
        else{
            $workoutsQuery = "INSERT INTO workouts (time, distance, avgSplit, type, userId, testId) VALUES (".$results[$i]["time"].", ".$distance.",".$results[$i]["split"].", 'test', ".$results[$i]["userId"].", ".$testId.")";
            echo($workoutsQuery."<br>");
            $conn->query($workoutsQuery);
            $insertId = $conn->insert_id;
            $piecesQuery = "INSERT INTO pieces (workoutID, time, distance, restTime, avgSplit) VALUES(".$insertId.", ".$results[$i]["time"].", ". $distance.", 0, ".$results[$i]["split"].")";
            echo($piecesQuery."<br>");
            $conn->query($piecesQuery);
            print_r($_POST);
        }
        
    }
?>
<html>
    <body>
        <form id="f" action="../testResults.php" method="POST">
            <input type="hidden" value='<?php echo $_POST["results"] ?>' name="results"></input> 
            <input type="hidden" value='<?php echo $distance ?>' name="distance"></input>
            <input type="hidden" value='<?php echo $title ?>' name="title"></input>
        </form>
    </body>
    <script>
        document.getElementById("f").submit();
    </script>
</html>