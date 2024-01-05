<?php
    include_once '../databaseCreds.php';
    include_once '../timeAndSplitConverter.php';
    //assign the start and end date
    $startDate = "'".$_GET["startDate"]."'";
    $endDate = "'".$_GET["endDate"]."'";

    
    
    $filters = " w.type = 'test' AND t.teamId = ".$_GET["teamId"]." AND t.date BETWEEN ".$startDate." AND ".$endDate;
    //initalize an array to hold the data
    $times = array();
    $splits = array();
    
    
    //get all the names of the people who tested
    $query = "SELECT DISTINCT(u.name) FROM workouts AS w JOIN tests as t on w.testID = t.ID JOIN users AS u on u.ID = w.userID WHERE".$filters;
    $athleteNames = $conn->query($query);
    while($name = $athleteNames->fetch_assoc()){
        $times[$name["name"]] = array();
        $splits[$name["name"]] = array();
    }
    
    
    //get the results of all the tests
    $query = "SELECT w.time, w.avgSplit, u.name, t.title FROM workouts AS w JOIN tests as t on w.testID = t.ID JOIN users AS u on u.ID = w.userID WHERE".$filters." ORDER BY t.date DESC,  w.time ASC";
    $testResults = $conn->query($query);
    while ($test = $testResults->fetch_assoc())
    {
        $times[$test["name"]][$test["title"]] = $test["time"];
        $splits[$test["name"]][$test["title"]] = $test["avgSplit"];
    }
    
    echo "<tr><th>Name</th>";

    //get all the titles of peoplw who participated
    $query = "SELECT DISTINCT(t.title) FROM workouts AS w JOIN tests as t on w.testID = t.ID JOIN users AS u on u.ID = w.userID WHERE".$filters;
    $testTitles = $conn->query($query);
    $titles = array();
    //print all the test titles out with columnspan = 2 so there is room for time and split under them
    while($title = $testTitles->fetch_assoc()){
        echo "<th colspan=\"2\">".$title["title"]."</th>";
        $titles[] = $title["title"];
    }
    echo "</tr>";
    //end the row and start a new one
    echo "<tr>";
    echo "<th></th>"; //under name should have no subheader
    for($i=0; $i<count($titles); $i++){
        echo "<th>Time</th>";
        echo "<th>Split</th>";
    }
    foreach($times as $person => $testTime){
        echo "<tr>";
        echo "<td>".$person."</td>";
        foreach($titles as $title){
            if(array_key_exists($title, $testTime)){
                echo "<td>".formatTime($testTime[$title])."</td>";
                echo "<td>".formatTime($splits[$person][$title])."</td>";
            }
            else{
                echo "<td></td><td></td>";
            }
        }
        echo "</tr>";
    }
 
    echo"</tr>";
?>