<html lang="en" data-bs-theme="dark">
    <?php include_once 'databaseCreds.php'; //use the database?>
    <?php include_once 'timeAndSplitConverter.php'; ?>
    <head>
    	<title>Test Results</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
			
    <body>
        <?php
        include_once 'navBar.php'; //add navbar 
        //initialize vars
        $results = json_decode($_POST["results"], true);
        $userId = $_SESSION["userId"];
        $distance = $_POST["distance"];
        $testId = $_POST["testId"];
        $testTitle = $_POST["title"];
        //we need to get all the names of the rowers to match into our result array on user id
        $query = "SELECT ID, name FROM users WHERE isActive=1";
        $numRows = 0;
        $users = $conn->query($query);
        while($user = $users->fetch_assoc()){
            for($i=0; $i<count($results); $i++){
                if($user["ID"] == $results[$i]["userId"]){
                    $results[$i]["name"] = $user["name"]; //set the name
                    $results[$i]["lastTime"] = "Not Found"; //the last time to not found incase they dont have a previous test
                    $results[$i]["lastSplit"] = "Not Found"; //same with last split
                }
            }
        }
        //create a query to get the results of the last tests of rowers
        $filter = "WHERE (userId=".$results[0]["userId"];
        for($i=1; $i<count($results); $i++){
                $filter = $filter." OR userId=".$results[$i]["userId"];
        }
        $filter = $filter.") AND (NOT date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND DATE_ADD(CURDATE(), INTERVAL 1 DAY)) AND distance=".$distance;
        $query = "SELECT * FROM workouts WHERE ID IN(SELECT MAX(ID) FROM workouts ".$filter." GROUP BY userId)"; //this query pulls the most recent test for each rower that has one with the same distacnce
        $previousTests = $conn->query($query);
        //fill in the last test results for anyone that has one
        while($lastTest = $previousTests->fetch_assoc()){
            for($i=0; $i<count($results); $i++){
                if($lastTest["userID"] == $results[$i]["userId"]){
                    $results[$i]["lastTime"] = $lastTest["time"];
                    $results[$i]["lastSplit"] = $lastTest["avgSplit"];
                    break;
                }
            }
        }
        ?>
        <br>
            <div class="d-flex justify-content-center">
                <h1 class="display-1"><?php echo $testTitle." Results"; ?></h1>
            </div>
            <div class="d-flex justify-content-center">
                <h3>Distance: <?php echo $distance ?></h3>
            </div>
            <br><br>
        <div class="container">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">
                    <table class="table table-responsive table-striped table-bordered w-100 text-align-center" id="resultsTable" style="text-align: center; border: 3px solid white">
                        <tr>
                            <th style="width: 16%;">Name</th>
                            <th style="width: 16%;">Last Time</th>
                            <th style="width: 16%;">Last Split</th>
                            <th style="width: 16%;">Time</th>
                            <th style="width: 16%;">Split</th>
                            <th style="width: 16%;">Time Improvement</th>
                            <?php
                                //add a row for all the results
                                for($i=0; $i<count($results);$i++){
                                    echo "<tr>";
                                    echo "<td>".$results[$i]["name"]."</td>"; //name
                                    echo "<td>".formatTime($results[$i]["lastTime"])."</td>"; //last time
                                    echo "<td>".formatTime($results[$i]["lastSplit"])."</td>"; //last split
                                    if($results[$i]["time"] == 0){ //if time is 0 set the result time and split to DNF and improvement to NA
                                        echo "<td>DNF</td>"; 
                                        echo "<td>DNF</td>";
                                        echo "<td>NA</td>";
                                    }
                                    else{ //otherwise set it to their values
                                        echo "<td>".formatTime($results[$i]["time"])."</td>"; 
                                        echo "<td>".formatTime($results[$i]["split"])."</td>";
                                        if($results[$i]["lastTime"] == "Not Found"){ //if rower doesn't have last test, set last result to na
                                            echo "<td>NA</td>";
                                        }
                                        else{ //if they do have a test
                                            $improvement = $results[$i]["lastTime"] - $results[$i]["time"]; //set the improvement to the last time - the current time
                                            $color = "";
                                            if ($improvement < 1 && $improvemnt > -1){ //if the improvement or loss is within 1 sec, set the color to yellow
                                                $color = "#F8DE7E";
                                            }
                                            else if($improvement > 0){ //otherwise if the improvement is greater then 0 the rower got faster so set the background color to green
                                                $color = "#28a745";
                                            }
                                            
                                            else{ //otherwise they got slower so set the color to red
                                                $color = "#93303b";
                                            }
                                            echo "<td style='background-color: ".$color."'>".formatTime($improvement)."</td>";
                                        }
                                    }
                                    echo "</tr>";
                                    
                                }
                            ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
                <a href="pieceTrackerHome.php" class="btn btn-lg" style="background-color: #52307c;">Return Home</a>
            </div>
    </body>
</html>