<html lang="en" data-bs-theme="dark">
    <?php include_once 'databaseCreds.php'; //use the database?>
    <head>
    	<title>Run Test</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/2.0.0/sweetalert2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/2.0.0/sweetalert2.min.js"></script>
    </head>
			
    <body>
        <?php
            include_once 'navBar.php'; //add navbar 
            $rowersInfo = json_decode($_POST["rowersInfo"], true);
            $userId = $_SESSION["userId"];
            $distance = $_POST["distance"];
            $testId = $_POST["testId"];
            $testTitle = $_POST["testTitle"];
            $query = "SELECT ID, name FROM users WHERE isActive=1";
            $numRows = 0;
            $users = $conn->query($query);
            while($user = $users->fetch_assoc()){
                for($i=0; $i<count($rowersInfo); $i++){
                    if($user["ID"] == $rowersInfo[$i]["userId"]){
                        $rowersInfo[$i]["name"] = $user["name"];
                    }
                }
            }
            
        ?>
        <div class="container">
            <br>
            <div class="d-flex justify-content-center">
                <h1 class="display-1"><?php echo $testTitle; ?></h1>
            </div>
            <div class="d-flex justify-content-center">
                <h3>Distance: <?php echo $distance ?></h3>
            </div>
            <br><br>
            <div class="row">
                <div class="col-12 col-md-1">
                </div>
                <div class="col-12 col-md-10">
                    <table class="table table-responsive table-striped w-100" id="resultsTable" style="text-align: center; border: 3px solid white">
                        <tr style="border-bottom: 2px solid #fff">
                            <th><h6>Name</h6></th>
                            <th><h6>Goal Time</h6></th>
                            <th><h6>Goal Split</h6></th>
                            <th class="th-lg"><h6>Result Time</h6></th>
                            <th class="th-lg"><h6>Result Split</h6></th>
                            <th><h6>Mark DNF</h6></th>
                            <th><h6>Done</h6></th>
                        </tr>
                    
                    <?php
                        for ($i=0; $i<count($rowersInfo); $i++){
                            $numRows++;
                            echo "<tr>";
                            echo "<td style='width: 14%'><p id='".$rowersInfo[$i]["userId"]."|rowerName'>".$rowersInfo[$i]["name"]."</p></td>\n";
                            echo "<td style='width: 14%'><p id='".$rowersInfo[$i]["userId"]."|goalTime'>".$rowersInfo[$i]["time"]."</td>";
                            echo "<td style='width: 14%'><p id='".$rowersInfo[$i]["userId"]."|goalSplit'>".$rowersInfo[$i]["split"]."</td>\n";
                            echo "<td style='width: 14%; min-width: 8em;'><div class='input-group'><input type='number' id='".$rowersInfo[$i]["userId"]."|timeMins' name='timeMins' class='text form-control rounded w-25' onInput=\"validateMinsInput(this, 'time')\" aria-describedby='basic-addon3' placeholder='mins'>:<input type='number' id='".$rowersInfo[$i]["userId"]."|timeSecs' name='timeSecs' class='form-control rounded w-25' onInput=\"validateSecsInput(this, 'time')\" aria-describedby='basic-addon3' placeholder='secs'></div></td>\n";
                            echo "<td style='width: 14%; min-width: 8em;'><div class='input-group'><input type='number' id='".$rowersInfo[$i]["userId"]."|splitMins' name='splitMins' class='form-control rounded w-25' onInput=\"validateMinsInput(this, 'split')\" aria-describedby='basic-addon3' placeholder='mins'>:<input type='number' id='".$rowersInfo[$i]["userId"]."|splitSecs' name='splitSecs' class='form-control rounded w-25' onInput=\"validateSecsInput(this, 'split')\" aria-describedby='basic-addon3' placeholder='secs'></div></td>\n";
                            echo "<td style='width: 14%'><button id='".$rowersInfo[$i]["userId"]."|dnfBtn' class='btn' style='background-color: #52307c' onClick='markDNF(this)' onMouseLeave=\"this.style.backgroundColor='#52307c'\" onMouseOver=\"this.style.backgroundColor='#444'\">DNF</button></td>\n";
                            echo "<td style='width: 14%'><button id='".$rowersInfo[$i]["userId"]."|submitBtn' class='btn' style='background-color: #52307c' onClick='markDone(this)' onMouseLeave=\"this.style.backgroundColor='#52307c'\" onMouseOver=\"this.style.backgroundColor='#444'\" disabled>Done</button></td>\n";
                            echo "</tr>";
                            
                        }
                    ?>
                    </table>
                    <br>
                    <div class="d-flex justify-content-center">
                        <button id="finishTestBtn" class='btn btn-lg' onclick = "submitTest()" style='background-color: #52307c' onMouseLeave="this.style.backgroundColor='#52307c'" onMouseOver="this.style.backgroundColor='#444'" disabled>Finish Test</button>
                    </div>
                </div>
                <div class="col-12 col-md-1"></div>
            </div>
        </div>
        <br>
        
        <script>
        
        var numSplits = 0<?php echo $distance/500 ?>;
        var numRows = 0<?php echo $numRows ?>;
        var numRowsFilled = 0;
            
            //gets the userId from an elementId
            function getElementGroupUserId(element){
                return element.id.split("|")[0];
            }
            
            //gets the alternate pair
            function getAlternatePair(pair){
                if(pair == "time"){
                    return "split";
                }
                return "time";
            }
            
            //formats mins and secs into a time
            function formatTime(mins, secs){
                return "" + mins + ":" + secs;
            }
            
            //fills inputs
            function fillInputs(userId, getPair){
                var fillPair = getAlternatePair(getPair);
                var getMins = document.getElementById(userId + "|" + getPair + "Mins");
                var getSecs = document.getElementById(userId + "|" + getPair + "Secs");
                var fillMins = document.getElementById(userId + "|" + fillPair + "Mins");
                var fillSecs = document.getElementById(userId + "|" + fillPair + "Secs");
                if(getPair == "time"){
                    var totalTime = convertMinsSecsToSecs(getMins.value, getSecs.value);
                    totalTime /= numSplits;
                    timeVars = convertSecsToMinsSecs(totalTime).split(":");
                    fillMins.value = timeVars[0];
                    if (timeVars[1] < 10){
                        fillSecs.value = "0" + timeVars[1];
                    }
                    else{
                        fillSecs.value = timeVars[1];
                    }
                }
                else{
                    var totalTime = convertMinsSecsToSecs(getMins.value, getSecs.value);
                    totalTime *= numSplits;
                    timeVars = convertSecsToMinsSecs(totalTime).split(":");
                    fillMins.value = timeVars[0];
                    fillSecs.value = timeVars[1];
                    if (timeVars[1] < 10){
                        fillSecs.value = "0" + timeVars[1];
                    }
                    else{
                        fillSecs.value = timeVars[1];
                    }
                }
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
            
            //checks if the button should be enabled
            function checkEnableButton(userId, pair){
                var mins = document.getElementById(userId + "|" + pair + "Mins");
                var secs = document.getElementById(userId + "|" + pair + "Secs");
                if(mins.value == "" || secs.value == ""){
                    document.getElementById(userId + "|submitBtn").disabled = true;
                }
                else{
                    document.getElementById(userId + "|submitBtn").disabled = false;
                    fillInputs(userId, pair);
                }
            }
            
            function checkEnableFinishButton(){
                if(numRowsFilled == numRows){
                    document.getElementById("finishTestBtn").disabled = false;
                }
                else{
                    document.getElementById("finishTestBtn").disabled = true;
                }
            }
            
            //validates seconds input
            function validateSecsInput(num, pair){
                if(num.value< 0){
                    num.value = 0;
                }
                else if(num.value > 59.9){
                    num.value = 59;
                }
                else if(num.value.length > 4){
                    num.value = num.value.slice(0, 4);
                }
                checkEnableButton(getElementGroupUserId(num), pair);
            }
            
            //validate mins input
            function validateMinsInput(num, pair){
                if(num.value <0){
                    num.value = 0;
                }
                else if(num.value.indexOf(".") != -1){
                    temp = num.value.split(".");
                    num.value = temp[0]
                }
                else{
                    checkEnableButton(getElementGroupUserId(num), pair);
                }
            }
            
            //asks the user to confirm and if they do mark the rower as DNF
            function markDNF(btn){
                 swal({
                        title: 'Are You Sure?', confirmButtonText: 'Confirm',
                        text: "",  
                        html: "<h6 style='color: #222'>This action can not be undone</h6>",
                        showCancelButton: true,
                        cancelButtonText: "Cancel "
                    }).then((isConfirm) => {
                        if (isConfirm) {
                            var userId = getElementGroupUserId(btn);
                            var timeMins = document.getElementById(userId + "|timeMins");
                            var timeSecs = document.getElementById(userId + "|timeSecs");
                            var splitMins = document.getElementById(userId + "|splitMins");
                            var splitSecs = document.getElementById(userId + "|splitSecs");
                            var submitBtn = document.getElementById(userId+ "|submitBtn");
                            timeMins.value = 0;
                            timeSecs.value = 0;
                            splitMins.value = 0;
                            splitSecs.value = 0;
                            timeMins.disabled = true;
                            timeSecs.disabled = true;
                            splitMins.disabled = true;
                            splitSecs.disabled = true;
                            timeMins.style.backgroundColor = "#93303b";
                            timeSecs.style.backgroundColor = "#93303b";
                            splitMins.style.backgroundColor = "#93303b";
                            splitSecs.style.backgroundColor = "#93303b";
                            document.getElementById(userId + "|rowerName").style.color = "#93303b";
                            document.getElementById(userId + "|goalTime").style.color = "#93303b";
                            document.getElementById(userId + "|goalSplit").style.color = "#93303b";
                            btn.style.backgroundColor = "#dc3545";
                            btn.onmouseover = function() {};
                            btn.onmouseleave = function() {};
                            submitBtn.style.backgroundColor = "#dc3545";
                            submitBtn.onmouseover = function() {};
                            submitBtn.onmouseleave = function() {};
                            btn.disabled = true;
                            numRowsFilled++;
                            checkEnableFinishButton();
                        }
                    });  
            }
            //handles what to do when the user hits the done button
            function markDone(btn){
                var userId = getElementGroupUserId(btn);
                var timeMins = document.getElementById(userId + "|timeMins");
                var timeSecs = document.getElementById(userId + "|timeSecs");
                var splitMins = document.getElementById(userId + "|splitMins");
                var splitSecs = document.getElementById(userId + "|splitSecs");
                var submitBtn = document.getElementById(userId + "|submitBtn");
                timeMins.disabled = true;
                timeSecs.disabled = true;
                splitMins.disabled = true;
                splitSecs.disabled = true;
                btn.innerHTML = "Edit"; 
                timeMins.style.backgroundColor = "#28a745";
                timeSecs.style.backgroundColor = "#28a745";
                splitMins.style.backgroundColor = "#28a745";
                splitSecs.style.backgroundColor = "#28a745";
                btn.style.backgroundColor = "#28a745";
                document.getElementById(userId + "|dnfBtn").style.backgroundColor = "#28a745";
                document.getElementById(userId + "|dnfBtn").disabled = true;
                submitBtn.onmouseover = function() {};
                submitBtn.onmouseleave = function() {};
                submitBtn.onclick = function(){enableEdit(submitBtn);};
                numRowsFilled++;
                checkEnableFinishButton();
            }
            
            function enableEdit(btn){
                numRowsFilled --;
                checkEnableFinishButton();
                var userId = getElementGroupUserId(btn);
                var timeMins = document.getElementById(userId + "|timeMins");
                var timeSecs = document.getElementById(userId + "|timeSecs");
                var splitMins = document.getElementById(userId + "|splitMins");
                var splitSecs = document.getElementById(userId + "|splitSecs");
                var submitBtn = document.getElementById(userId+ "|submitBtn");
                var dnfBtn = document.getElementById(userId + "|dnfBtn");
                timeMins.disabled = false;
                timeSecs.disabled = false;
                splitMins.disabled = false;
                splitSecs.disabled = false;
                btn.innerHTML = "Done";
                btn.style.backgroundColor = "#52307c";
                timeMins.style.backgroundColor = "#222529";
                timeSecs.style.backgroundColor = "#222529";
                splitMins.style.backgroundColor = "#222529";
                splitSecs.style.backgroundColor = "#222529";
                dnfBtn.style.backgroundColor = "#52307c";
                btn.onmouseover = function() {};
                btn.onmouseleave = function() {};
                btn.onclick = function(){markDone(btn);};
                submitBtn.onmouseover = function() {submitBtn.style.backgroundColor = '#444'};
                submitBtn.onmouseleave = function() {submitBtn.style.backgroundColor = '#52307c'};
                dnfBtn.disabled = false;
            }
            
            function submitTest(){
                swal({
                        title: 'Are You Sure?', confirmButtonText: 'Confirm',
                        text: "",  
                        html: "<h6 style='color: #222'>This action can not be undone</h6>",
                        showCancelButton: true,
                        cancelButtonText: "Cancel "
                    }).then((isConfirm) => {
                        if (isConfirm) {
                            var results = [];
                            var timeMinsElems = document.getElementsByName("timeMins");
                            var timeSecsElems = document.getElementsByName("timeSecs");
                            var splitMinsElems = document.getElementsByName("splitMins");
                            var splitSecsElems = document.getElementsByName("splitSecs");
                            var timeMins = 0;
                            var timeSecs = 0;
                            var splitMins = 0;
                            var splitSecs = 0;
                            for(let i = 0; i<timeMinsElems.length; i++){
                                userId = getElementGroupUserId(timeMinsElems[i]);
                                timeMins = timeMinsElems[i].value;
                                for(let j=0; j<timeSecsElems.length; j++){
                                    if (timeSecsElems[j].id.split("|")[0] == userId){
                                        timeSecs = timeSecsElems[j].value;
                                    }
                                    if (splitMinsElems[j].id.split("|")[0] == userId){
                                        splitMins = splitMinsElems[j].value;
                                    }
                                    if (splitSecsElems[j].id.split("|")[0] == userId){
                                        splitSecs = splitSecsElems[j].value;
                                    }
                                }
                                results.push({userId: userId, time: convertMinsSecsToSecs(timeMins,timeSecs), split: convertMinsSecsToSecs(splitMins,splitSecs)});
                                var f = document.createElement("form");
                                f.method = "POST";
                                f.action = "ajaxScripts/insertTestResults.php";
                                document.body.appendChild(f);
                                var testResults = document.createElement("input");
                                testResults.type = "hidden";
                                testResults.value = JSON.stringify(results);
                                testResults.name = "results";
                                var distance = document.createElement("input");
                                distance.value = "<?php echo $distance; ?>";
                                distance.name = "distance";
                                distance.type = "hidden";
                                var testId = document.createElement("input");
                                testId.value = "<?php echo $testId; ?>";
                                testId.name = "testId";
                                testId.type = "hidden";
                                var title = document.createElement("input");
                                title.value = '<?php echo $testTitle; ?>';
                                title.name = "title";
                                title.type = "hidden";
                                f.appendChild(testId);
                                f.appendChild(distance);
                                f.appendChild(title);
                                f.appendChild(testResults);
                                f.submit();
                            }
                        }
                    });

            }
        </script>
    </body>
</html>