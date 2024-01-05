<html lang="en" data-bs-theme="dark">
    <?php include_once 'databaseCreds.php'; //use the database
    include_once 'timeAndSplitConverter.php'?>
    <head>
    	<title>Test History</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </head>
			
    <body>
        <?php include_once 'navBar.php'; //add navbar ?>
        <br>
        <?php
        //get the info for the user's team
            $query = "SELECT t.name, t.ID from users AS u JOIN teams AS t on t.ID = u.teamID WHERE u.ID = ".$_SESSION["userId"];
            $userInfo = $conn->query($query)->fetch_assoc();
        ?>
        <div class="d-flex justify-content-center">
            <!-- display the team and Tests as a tile for the page -->
            <h1 class="display-1 text-align-center"><?php echo $userInfo["name"]; ?> Tests</h1>
        </div>
        
        
        <!-- using columns for easy centering and more control -->
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="col col-xs-12 col-lg-2"></div>
                <div class="col col-xs-12 col-lg-8">
                    <select id="season" onChange="changeSeason()">
                        <option id="default">Active Rowers</option>
                        <?php 
                            $query = "SELECT * from seasons WHERE teamId = ".$userInfo["ID"]." ORDER BY startDate DESC";
                            $seasons = $conn->query($query);
                            if(mysqli_num_rows($seasons) > 0){
                                while($season = $seasons->fetch_assoc()){
                                    echo "<option id='".$season["startDate"]."|".$season["endDate"]."'>".$season["name"]."</option>";
                                }
                            }
                        ?>
                    </select>
                    <div class="table-responsive">
                        <?php
                        //assign the start and end date
                        $startDate = "'2022-8-1'";
                        $endDate = "'2023-7-31'";
                        
                        
                        
                        $filters = " w.type = 'test' AND u.isActive = 1 AND t.teamId = ".$userInfo["ID"];
                        //initalize 2 arrays to hold the data
                        $times = array();
                        $splits = array();
                        
                        
                        //get all the names of the people who tested
                        $query = "SELECT DISTINCT(u.name) FROM workouts AS w JOIN tests as t on w.testID = t.ID JOIN users AS u on u.ID = w.userID WHERE".$filters;
                        $athleteNames = $conn->query($query);
                        
                        //initialize arrays within the array
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
                        ?>
                        
                        <table class="table table-responsive table-striped table-bordered w-100 text-align-center" id="dataTable" style="text-align: center">
                            <tr>
                                <th>Name</th>
                                <?php
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
                                    //create a row for each person
                                    foreach($times as $person => $testTime){
                                        echo "<tr>";
                                        echo "<td>".$person."</td>"; //name in first column
                                        foreach($titles as $title){ //foreach test
                                            if(array_key_exists($title, $testTime)){ //if the paricipated in the test print thier time and split for the test
                                                echo "<td>".formatTime($testTime[$title])."</td>";
                                                echo "<td>".formatTime($splits[$person][$title])."</td>";
                                            }
                                            else{ //otherwise put in empty cells for that test
                                                echo "<td></td><td></td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                    ?>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col col-xs-12 col-lg-2"></div>
            </div>
        </div>
        <script>
        //save the default page (a page that shows all times for all the athletes currently on the team)
            var activeTable = document.getElementById("dataTable").innerHTML;
            
            function changeSeason(){
                var select = document.getElementById("season");
                if(select.selectedIndex == 0){ //if its the first option, just make the table the saved table
                    document.getElementById("dataTable").innerHTML = activeTable;
                    return 0;
                }
                //otherwise continue and use an ajax call to get the table data for the selected season
                var dates = select[select.selectedIndex].id.split("|");
                $.ajax({ 
                   method: "GET",
                   url: "ajaxScripts/getTestHistory.php",
                   data:{
                       startDate: dates[0],
                       endDate: dates[1],
                       teamId: <?php echo $userInfo["ID"]; ?>
                   },
                   success: function(data){
                       console.log(data);
                       document.getElementById("dataTable").innerHTML = data;
                   }
                });
            }
        </script>
    </body>
</html>