<html lang="en" data-bs-theme="dark">
    <?php 
        include_once 'databaseCreds.php'; //use the database
        include_once 'timeAndSplitConverter.php';

    ?>
    <head>
    	<title>Select Rowers</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </head>
			
    <body>
        <?php 
        include_once 'navBar.php'; //add navbar
        $userId = $_SESSION["userId"];
        $teamId = $_SESSION["teamId"];
        $distance = $_POST["distance"];
        $title = $_POST["title"];
        $testId = $_POST["testId"];
        ?>
        <br>

        <div class="d-flex justify-content-center">
            <h1 class="display-1"><?php echo $title; ?></h1>
        </div>
        <div class="d-flex justify-content-center">
            <h3>Distance: <?php echo $distance ?></h3>
        </div>
        <div class="container">
            <div class="row">
                <div class="col col-12 col-lg-6">
                    <div class="d-flex justify-content-center">
                        <h3 class="display-3">Select Rowers</h3>
                    </div>
                    <div class="d-flex justify-content-center">
                        <h6>Name:
                        <select onchange="getLastTest()" id="rowersSelect">
                            <option value="userId:0" selected disabled>Rowers</option>
                            <?php 
                                $query = "SELECT id, name FROM users WHERE teamId=".$teamId." AND isActive=1 ORDER BY name ASC"; 
                                $names = $conn->query($query);
                                while($name = $names->fetch_assoc()){
                                    echo "<option id='userId:".$name["id"]."'>".$name["name"]."</option>\n\t\t\t\t\t\t\t";
                                }
                            ?>
                        </select>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-center">
                        <p id="lastTime">Last Time: &emsp;</p>
                        <p id="lastSplit">Last Split:</p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="input-group mb-3 w-75">
                            <div class="input-group-prepend rounded-left">
                                <span class="input-group-text" style='background-color: #52307c' id="basic-addon3">Goal Time:</span>
                            </div>
                            <input type="text" onInput="timeInput()" class="form-control rounded" id="goalTimeMinsBox" name="goalTimeMinsBox" aria-describedby="basic-addon3" placeholder="mins">
                            :<input type="text" onInput="timeInput()" class="form-control rounded" id="goalTimeSecsBox" name="goalTimeSecsBox" aria-describedby="basic-addon3" placeholder="secs">
                            &nbsp;<button class="btn btn-md" id="fillSplit()" onClick="fillSplit()" style='background-color: #52307c'>Fill Split</button>
                        </div>
                        
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="input-group mb-3 w-75">
                            <div class="input-group-prepend rounded-left">
                                <span class="input-group-text" style='background-color: #52307c' id="basic-addon3">Goal Split:</span>
                            </div>
                            <input type="text" onInput="splitInput()" class="form-control rounded" id="goalSplitMinsBox" name="goalSplitMinsBox" aria-describedby="basic-addon3" placeholder="mins">
                            :<input type="text" onInput="splitInput()" class="form-control rounded" id="goalSplitSecsBox" name="goalSplitSecsBox" aria-describedby="basic-addon3" placeholder="secs">
                            &nbsp;<button class="btn btn-md" id="fillTime()" onClick="fillTime()" style='background-color: #52307c'>Fill Time</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button id="addRowerBtn" class="btn btn-lg" style='background-color: #52307c' onMouseLeave="this.style.backgroundColor='#52307c'" onMouseOver="this.style.backgroundColor='#444'" onClick='addToList()' disabled>Add Rower</button>
                    </div>
                    <br>
                </div>
                
                <div class="col col-12 col-lg-6">
                    <div class="d-flex justify-content-center">
                        <h3 class="display-3">Selected Rowers</h3>
                    </div>
                    <table class="table table-responsive table-striped table-bordered w-100 text-align-center" id="rowerTable" style="text-align: center; border: 3px solid white">
                        <tr style="border-bottom: 3px solid white">
                            <th style="width: 16%;">Name</th>
                            <th style="width: 16%;">Last Split</th>
                            <th style="width: 16%;">Last Time</th>
                            <th style="width: 16%;">Goal Split</th>
                            <th style="width: 16%;">Goal Time</th>
                            <th style="width: 16%;">Remove</th>
                        </tr>
                    </table>
                    <div class="d-flex justify-content-center">
                        <Button id="startTestBtn" class="btn btn-lg" style='background-color: #52307c' onClick="startTest()" onMouseLeave="this.style.backgroundColor='#52307c'" onMouseOver="this.style.backgroundColor='#444'" disabled>Start Test</Button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            //store the values so they can be used across methods
            var time = "0:00";
            var split = "0:00";
            var distance = "" + <?php echo $distance ?>;
            var numSplits = distance / 500;
            var tableRow = 0;
            var rowers = [];
        
            //time input event
            function timeInput(){
                checkEnableAddRowerButton()
            }
            
            //split input evetn
            function splitInput(){
                checkEnableAddRowerButton()
            }
            
            //formats mins and secs into a time
            function formatTime(mins, secs){
                return "" + mins + ":" + secs;
            }
            
            //checks if a value is a number
            function checkNumber(value) {
                return value % 1 == 0;
            }
            
            //converts mins and secs to total secs
            function convertMinsSecsToSecs(mins, secs){
                return parseInt(mins)*60+parseFloat(secs);
            }
            
            //convert secs to mins:secs
            function convertSecsToMinsSecs(inp){
                let secs = parseFloat(inp);
                secs*=10;
                remainingSecs = secs % 600;
                mins = secs-remainingSecs;
                mins /= 10;
                remainingSecs /= 10;
                mins /= 60;
                return formatTime(mins, remainingSecs);
            
            }
        
            //gets the last test a user
            //happens on select option changed
            function getLastTest(){
                var rowersSelect = document.getElementById("rowersSelect");
                var cont="false";
                $.ajax({ 
                   method: "GET",
                   url: "ajaxScripts/getLastTestTime.php",
                   data:{
                       userId: rowersSelect[rowersSelect.selectedIndex].id.slice(7),
                       distance: <?php echo $distance; ?>
                   },
                   success: function(data){
                       var lastTestData = data.split("|");
                       //if there is no previous tests, clear the values and show no things found
                       if(data == "None Found"){
                           document.getElementById("lastTime").innerHTML = "No Previous Tests Found";
                           document.getElementById("lastSplit").innerHTML = "";
                           document.getElementById("goalTimeMinsBox").value = "";
                           document.getElementById("goalTimeSecsBox").value = "";
                           document.getElementById("goalSplitMinsBox").value = "";
                           document.getElementById("goalSplitSecsBox").value = "";
                       }
                       else{ //if there is a test
                           //if the time currently in the input is the same, we want to overwrite the code
                           if(time == (document.getElementById("goalTimeMinsBox").value + ":" + document.getElementById("goalTimeSecsBox").value) || split == (document.getElementById("goalSplitMinsBox").value + ":" +document.getElementById("goalSplitSecsBox").value)){
                               cont = true;
                           }
                           time = lastTestData[0];
                           split = lastTestData[1];
                           document.getElementById("lastTime").innerHTML = "Last Time: " + time + "&emsp;";
                           document.getElementById("lastSplit").innerHTML = "Last Split: "+ split;
                           var timeVars = time.split(":");
                           var splitVars = split.split(":");
                           //if the value is empty, or the input is the same as the default for the last selectd rower fill it
                           if(document.getElementById("goalTimeMinsBox").value == "" || cont){
                               document.getElementById("goalTimeMinsBox").value = timeVars[0];
                           }
                           if(document.getElementById("goalTimeSecsBox").value == "" || cont){
                               document.getElementById("goalTimeSecsBox").value = timeVars[1];
                           }
                           if(document.getElementById("goalSplitMinsBox").value == ""  || cont){
                                document.getElementById("goalSplitMinsBox").value = splitVars[0];
                           }
                           if(document.getElementById("goalSplitSecsBox").value == "" || cont){
                                document.getElementById("goalSplitSecsBox").value = splitVars[1];
                           }
                           document.getElementById("addRowerBtn").disabled = false;
                       }
                   }
                });
            }
            
            //validates split then calculates time based on split
            function fillTime(){
                var splitMins = document.getElementById("goalSplitMinsBox").value;
                var splitSecs = document.getElementById("goalSplitSecsBox").value;
                var timeMins = document.getElementById("goalTimeMinsBox").value;
                var timeSecs = document.getElementById("goalTimeSecsBox").value;
                var valid = false;
                if(document.getElementById("rowersSelect").selectedIndex == 0){
                    valid=false;
                }
                else if(splitSecs<0 || splitSecs > 59){
                    valid=false;
                }
                else if(!checkNumber(splitSecs*10) || !checkNumber(splitMins*10)){
                    valid=false;
                }
                else if(splitSecs.length < 2 || (splitSecs.indexOf(".")!= 2&& splitSecs.indexOf(".") != -1)){
                    valid=false
                }
                else if(splitMins != "" && splitSecs != ""){
                    valid=true;
                }
                else{
                   valid=false;
                }
                if(valid){
                    time = convertSecsToMinsSecs(convertMinsSecsToSecs(splitMins, splitSecs)*numSplits).split(":");
                    document.getElementById("goalTimeMinsBox").value = time[0];
                    var secs = ""+time[1];
                    if(time[1] < 10){
                        secs = "0"+time[1];
                    }
                    document.getElementById("goalTimeSecsBox").value = secs;
                    checkEnableAddRowerButton()
                }
            }
            
            //validates time and calculates and fills split input based on time
            function fillSplit(){
                var splitMins = document.getElementById("goalSplitMinsBox").value;
                var splitSecs = document.getElementById("goalSplitSecsBox").value;
                var timeMins = document.getElementById("goalTimeMinsBox").value;
                var timeSecs = document.getElementById("goalTimeSecsBox").value;
                var valid = false;
                if(document.getElementById("rowersSelect").selectedIndex == 0){
                    valid=false;
                }
                else if(timeSecs < 0 || timeSecs > 59){
                    valid=false;
                }
                else if(!checkNumber(timeSecs*10) || !checkNumber(timeMins*10)){
                    valid=false;
                }
                else if(timeSecs.length<2 || (timeSecs.indexOf(".") != 2 && timeSecs.indexOf(".") != -1)){
                    valid=false;
                }
                else if(timeMins !="" && timeSecs!=""){
                    valid=true;
                }
                else{
                    valid=false;
                }
                if(valid){
                    time = convertSecsToMinsSecs(convertMinsSecsToSecs(timeMins, timeSecs)/numSplits).split(":");
                    document.getElementById("goalSplitMinsBox").value = time[0];
                    var secs = ""+time[1];
                    if(time[1] < 10){
                        secs = "0"+time[1];
                    }
                    document.getElementById("goalSplitSecsBox").value = secs;
                    checkEnableAddRowerButton();
                }
            }
            
            //check if there is enough input to add
            function checkEnableAddRowerButton(){
                var splitMins = document.getElementById("goalSplitMinsBox").value;
                var splitSecs = document.getElementById("goalSplitSecsBox").value;
                var timeMins = document.getElementById("goalTimeMinsBox").value;
                var timeSecs = document.getElementById("goalTimeSecsBox").value;
                var addRowerBtn = document.getElementById("addRowerBtn");
                if(document.getElementById("rowersSelect").selectedIndex == 0){
                    addRowerBtn.disabled = true;
                }
                else if(splitSecs<0 || timeSecs < 0 || splitSecs > 59 || timeSecs > 59){
                    addRowerBtn.disabled = true;
                    alert("Seconds must be less than 60");
                }
                else if(!checkNumber(splitSecs*10) || !checkNumber(timeSecs*10) || !checkNumber(timeMins*10) || !checkNumber(splitMins*10)){
                    addRowerBtn.disabled = true;
                    alert("Must be a number with one decimal point or less");
                }
                else if(splitSecs.length < 2 || timeSecs.length<2 || (timeSecs.indexOf(".") != 2 && timeSecs.indexOf(".") != -1) || (splitSecs.indexOf(".")!= 2&& splitSecs.indexOf(".") != -1)){
                    addRowerBtn.disabled = true;
                }
                else if(splitMins != "" && splitSecs != "" && timeMins !="" && timeSecs!=""){
                    addRowerBtn.disabled = false;
                }
                else{
                    addRowerBtn.disabled = true;
                }
            }
            
            //add to a list
            function addToList(){
                var table = document.getElementById("rowerTable");
                var splitMins = document.getElementById("goalSplitMinsBox").value;
                var splitSecs = document.getElementById("goalSplitSecsBox").value;
                var timeMins = document.getElementById("goalTimeMinsBox").value;
                var timeSecs = document.getElementById("goalTimeSecsBox").value;
                var rowersSelect = document.getElementById("rowersSelect");
                var rower = {userId: rowersSelect[rowersSelect.selectedIndex].id.slice(7), time: formatTime(timeMins, timeSecs), split:formatTime(splitMins, splitSecs)};
                rowers.push(rower);
                console.table(rowers);
                var buttonHTML = "<button class='btn btn-sm' id='remove|"+rowersSelect.selectedIndex+"|"+tableRow+"' onClick='removeRow(this)'>Remove</button>";
                table.innerHTML += "<tr id='row:"+tableRow+"'><td>" + rowersSelect[rowersSelect.selectedIndex].innerHTML + "</td><td>"+split+"</td><td>"+time+"</td><td>"+formatTime(splitMins, splitSecs)+"</td><td>"+formatTime(timeMins, timeSecs)+"</td><td>"+buttonHTML+"</td></tr>";
                rowersSelect[rowersSelect.selectedIndex].disabled = true;
                rowersSelect.selectedIndex = 0;
                tableRow++;
                document.getElementById("addRowerBtn").disabled = true;
                document.getElementById("goalSplitMinsBox").value = "";
                document.getElementById("goalSplitSecsBox").value = "";
                document.getElementById("goalTimeMinsBox").value = "";
                document.getElementById("goalTimeSecsBox").value = "";
                document.getElementById("startTestBtn").disabled = false;
                document.getElementById("lastTime").innerHTML = "Last Time: &emsp;";
                document.getElementById("lastSplit").innerHTML = "Last Split:";
            }
            
            //removes row from table
            function removeRow(btn){
                var info = btn.id.split("|");
                console.table(info);
                var rowersSelect = document.getElementById("rowersSelect");
                rowersSelect[info[1]].disabled = false;
                document.getElementById("row:"+info[2]).remove();
                if(document.getElementById("rowerTable").rows.length < 2){
                    document.getElementById("startTestBtn").disabled = true;
                }
                for (let i = 0; i< rowers.length; i++){
                    if(rowers[i].userId == rowersSelect[info[1]].id.slice(7)){
                        if(i == 0){
                            rowers.shift();
                        }
                        else{
                            rowers.splice(i, i);
                        }
                    }
                }
                
                console.log("removed:");
                console.table(rowers);
            }
            
            //start the test
            function startTest(){
                var f = document.createElement("form");
                f.method = "POST";
                f.action = "runTest.php";
                var distance = document.createElement("input");
                distance.type = "hidden";
                distance.value = "<?php echo $distance;?>";
                distance.name = "distance";
                f.appendChild(distance);
                var testId = document.createElement("input");
                testId.type = "hidden";
                testId.value = '<?php echo $testId; ?>';
                testId.name = "testId";
                f.appendChild(testId);
                var rowersInfo = document.createElement("input");
                rowersInfo.type = "hidden";
                rowersInfo.value = JSON.stringify(rowers);
                rowersInfo.name = "rowersInfo";
                f.appendChild(rowersInfo);
                var testTitle = document.createElement("input");
                testTitle.type = "hidden";
                testTitle.value = '<?php echo $title ?>';
                testTitle.name = "testTitle";
                f.appendChild(testTitle);
                document.body.appendChild(f);
                f.submit();
            }
        </script>
    </body>
</html>