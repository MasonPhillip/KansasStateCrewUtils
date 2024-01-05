<html lang="en" data-bs-theme="dark">
    <?php 
        include_once 'databaseCreds.php'; //use the database
        $query = "SELECT code FROM teams WHERE ID=".$_SESSION["teamId"];
        $results = $conn->query($query)->fetch_assoc();
        $query = "SELECT code FROM teams";
        $teamCodes = $conn->query($query);
    ?>
    <head>
    	<title>Manage Team</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/2.0.0/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/2.0.0/sweetalert2.min.js"></script>
    </head>
			
    <body>
        <?php include_once 'navBar.php'; //add navbar ?>
        <br>
        <div class="d-flex justify-content-center">
            <h1 class="display-1">Manage Team</h1>
        </div>
        <?php 
            $query = "SELECT ID, name, isCoach, isActive FROM users WHERE teamID=".$_SESSION["teamId"]." ORDER BY isActive DESC, name ASC";
            $athletes = $conn->query($query);
        ?>
        <div class="container">
            <div class="row">
                <div class="col col-12 col-md-3">
                    <div class="d-flex justify-content-center">
                        <h3 class="display-3" style="text-align: center" >Change Team Code</h3>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style='background-color: #52307c'>Team Code</span>
                            </div>
                            <input type="text" class="form-control" id="teamCodeBox" name="teamCodeBox" aria-describedby="basic-addon3" value='<?php echo $results["code"];?>'>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn" style='background-color: #52307c' onclick="editTeamCode()">Change Team Code</button>
                    </div>
                    <br>
                </div>
                <div class="col col-12 col-md-6" style="border: 3px solid white">
                    <div class="d-flex justify-content-center">
                        <br>
                        <table class="table table-responsive table-striped table-bordered w-100 text-align-center mt-3" style="text-align: center">
                            <tr>
                                <th>Name</th>
                                <th>Active</th>
                                <th>Coach</th>
                            </tr>
                            <?php
                                while($athlete = $athletes->fetch_assoc()){
                                    echo "<tr>";
                                    echo "<td>".$athlete["name"]."</td>";
                                    if($athlete["isActive"] == 1){
                                        echo "<td><button class='btn' style='background-color: #52307c' value='".$athlete["ID"]."' onClick='editActive(this, 0)'>Make Inactive</button></td>";
                                    }
                                    else{
                                        echo "<td><button class='btn' style='background-color: #52307c' value='".$athlete["ID"]."' onClick='editActive(this, 1)'>Make Active</button></td>";
                                    }
                                    if($athlete["isCoach"] == 0){
                                        echo "<td><button class='btn' style='background-color: #52307c' value='".$athlete["ID"]."' onClick='editCoach(this, 1)'>Make Coach</button></td>";
                                    }
                                    else{
                                        echo "<td><button class='btn' style='background-color: #52307c' value='".$athlete["ID"]."' onClick='editCoach(this, 0)'>Remove Coach</button></td>";
                                    }
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                        
                    </div>
                </div>
                <div class="col col-12 col-md-3">
                    <div class="d-flex justify-content-center">
                        <h3 class="display-3" style="text-align: center" >Create Season</h3>
                    </div>
                    <br>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style='background-color: #52307c' id="basic-addon3">Season Name</span>
                        </div>
                        <input type="text" class="form-control" id="seasonNameBox" name="seasonNameBox" aria-describedby="basic-addon3"></input>
                    </div>
                    
                    <label>Start Date: </label> 
                    <div id="startDatepicker" class="input-group date" data-date-format="mm-dd-yyyy"> 
                        <input class="form-control" type="text" readonly /> 
                        <span class="input-group-addon"> 
                            <i class="glyphicon glyphicon-calendar"></i> 
                        </span> 
                    </div> 
                    <br>
                    <label>End Date: </label> 
                    <div id="endDatepicker" class="input-group date" data-date-format="mm-dd-yyyy"> 
                        <input class="form-control" type="text" readonly /> 
                        <span class="input-group-addon"> 
                            <i class="glyphicon glyphicon-calendar"></i> 
                        </span> 
                    </div>
                    <br>
                    <div class="d-flex justify-content-center">
                        <button class="btn" style='background-color: #52307c' onclick="createSeason()">Add Season</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"> </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"> </script>
        <script src= "https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"> </script> 
        <script>
        //enable functionality for the start date picker
        $(function () { 
            $("#startDatepicker").datepicker({  
                autoclose: true,  
                todayHighlight: true, 
            }).datepicker('update', new Date()); 
        }); 
        //add functionality for the end date picker
        $(function () { 
            $("#endDatepicker").datepicker({  
                autoclose: true,  
                todayHighlight: true, 
            }).datepicker('update', new Date()); 
        }); 
        
        function createSeason(){
            var startDate = $( "#startDatepicker" ).datepicker("getDate"); 
            var endDate = $( "#endDatepicker" ).datepicker("getDate"); 
            var seasonName = document.getElementById("seasonNameBox").value;
            if(seasonName == ""){
                alert("Please Enter a Season Name");
            }
            else{
                swal({
                        title: 'Please Confirm?', confirmButtonText: 'Confirm',
                        text: "",  
                        showCancelButton: true,
                        cancelButtonText: "Cancel "
                    }).then((isConfirm) => {
                        if (isConfirm) {
                            $.ajax({ 
                                method: "POST",
                                url: "ajaxScripts/insertSeason.php",
                                data:{
                                    teamId: 0<?php echo $_SESSION["teamId"];?>,
                                    startDate: JSON.stringify(startDate).slice(1,10),
                                    endDate: JSON.stringify(endDate).slice(1,10),
                                    name: seasonName
                                },
                                success: function(data){
                                    if(data == "success"){
                                        alert("Season Added");
                                    }
                                    else{
                                        console.log(data);
                                    }
                                }
                             });
				        }
			});  
            }
        }
        
            function editActive(btn, val){
                $.ajax({ 
                   method: "POST",
                   url: "ajaxScripts/editActive.php",
                   data:{
                       userId: btn.value,
                       active: val
                   },
                   success: function(data){
                       if(val == 0){
                           btn.innerHTML = "Make Active";
                           btn.setAttribute("onclick", "editActive(this, 1)");
                       }
                       else{
                           btn.innerHTML = "Make Inactive";
                           btn.setAttribute("onclick", "editActive(this, 0)");
                       }
                   }
                });
            }
            
            function editTeamCode(){
                if('<?php while($teamCode = $teamCodes->fetch_assoc()){ echo "|".$teamCode["code"]."|";}?>'.includes(document.getElementById("teamCodeBox").value)){
                    alert("Team Code already in use");
                    return 0;
                }
                swal({
                        title: 'Please Confirm?', confirmButtonText: 'Confirm',
                        text: "",  
                        showCancelButton: true,
                        cancelButtonText: "Cancel "
                    }).then((isConfirm) => {
                        if (isConfirm) {
                            $.ajax({ 
                                method: "POST",
                                url: "ajaxScripts/updateTeamCode.php",
                                data:{
                                    teamId: 0<?php echo $_SESSION["teamId"];?>,
                                    code: document.getElementById("teamCodeBox").value
                                },
                                success: function(data){
                                    if(data == "success"){
                                        alert("Team Code Updated");
                                    }
                                }
                             });
				        }
			});  
            }
            
            function editCoach(btn, val){
                $.ajax({ 
                   method: "POST",
                   url: "ajaxScripts/editCoach.php",
                   data:{
                       userId: btn.value,
                       coach: val
                   },
                   success: function(data){
                       if(val == 0){
                           btn.innerHTML = "Make Coach";
                           btn.setAttribute("onclick", "editCoach(this, 1)");
                       }
                       else{
                           btn.innerHTML = "Remove Coach";
                           btn.setAttribute("onclick", "editCoach(this, 0)");
                       }
                   }
                });
            }
        </script>
    </body>
</html>