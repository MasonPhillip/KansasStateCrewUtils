<html lang="en" data-bs-theme="dark">
    <?php 
        include_once 'databaseCreds.php'; //use the database
        $teamId = $_SESSION["teamId"];
    ?>
    <head>
    	<title>Test Info</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/2.0.0/sweetalert2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/2.0.0/sweetalert2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
			
    <body>
        <?php include_once 'navBar.php'; //add navbar ?>
        <br>
        <div class="row">
            <div class="col-1 col-lg-3"></div>
            <div class="col-12 col-md-12 col-lg-6 pb-3" style='border: solid 3px #AAA;'>
                <div class="d-flex justify-content-center">
                    <h1 class="display-1">Test Information</h1>
                </div>
                <br>
                <input type="hidden" value='<?php echo $_SESSION["userId"];?>' id="userId" name="userId"></input>
                <input type="hidden" value='<?php echo $teamId;?>' id="teamId" name="teamId"></input>
                
                <!-- input group for title -->
                <div class="d-flex justify-content-center">
                    <div class="input-group mb-3 sm-w-100 w-75">
                        <div class="input-group-prepend">
                            <span class="input-group-text rounded-left" style='background-color: #52307c' id="basic-addon3">Title</span>
                        </div>
                        <input type="text" class="form-control rounded" id="titleBox" name="titleBox" aria-describedby="basic-addon3"><p class="text-danger" id="nameWarning">*</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                <p>Enter the competition name, or your own name for the test</p>    
                </div>
                <br>
                
                <!--input group for distance -->
                <div class="d-flex justify-content-center">
                    <div class="input-group mb-3 sm-w-100 w-75">
                        <div class="input-group-prepend">
                            <span class="input-group-text rounded-left" style='background-color: #52307c' id="basic-addon3">Distance (meters)</span>
                        </div>
                        <input type="text" class="form-control rounded" id="distanceBox" name="distanceBox" aria-describedby="basic-addon3"><p class="text-danger" id="distanceWarning">*</p>
                    </div>
                </div>
                
                <!-- required check -->
                <div class="d-flex justify-content-center">
                    <h6 class="text-danger ">*required</h6>
                </div>
                <br>
                
                <!-- rower button -->
                <div class="d-flex justify-content-center"> 
            	    <button id="selectRowersBtn" class="btn btn-lg" style='background-color: #52307c' onClick='openSelectRowers()'>Select Rowers</button>
                </div>
            </div>
        </div>
        
        <script>
        
            //make it so if the user hits enter in the distance box
            var distanceBox = document.getElementById("distanceBox");
            distanceBox.addEventListener("keypress", function(event){
                if(event.key === "Enter"){
                    event.preventDefault();
                    document.getElementById("selectRowersBtn").click();
                    console.log("clicked");
                }
            });
        
        
            //handles the selectRowersBtn clicked event
            function openSelectRowers(){
                //get all the elements as vars
                var distance = document.getElementById("distanceBox");
                var userId = document.getElementById("userId");
                var teamId = document.getElementById("teamId");
                var title = document.getElementById("titleBox");
                var cont = 1; //var to track if an error message is shown
                if(title.value == ""){ //verify the title is not empty
                    document.getElementById("nameWarning").innerHTML = "*Required";
                    cont = 0;
                }
                if(distance.value == ""){ //verify the distance is not empty
                    document.getElementById("distanceWarning").innerHTML = "*Required";
                    cont = 0;
                }
                else if(!checkNumber(distance.value)){ //verify distance is a number
                    document.getElementById("distanceWarning").innerHTML = "*Must be a number";
                    cont = 0;
                }
                if(cont == 1){ //if all the verification is passed, confirm the user wants to start the test and enter
                    swal({
                        title: 'Please Confirm?', confirmButtonText: 'Confirm',
                        text: "",  
                        showCancelButton: true,
                        cancelButtonText: "Cancel "
                    }).then((isConfirm) => {
                        if (isConfirm) {
                    var f = document.createElement("form");
                    f.action = "ajaxScripts/insertTest.php";
                    f.method = "POST";
                    f.appendChild(userId);
                    f.appendChild(teamId);
                    f.appendChild(distance);
                    f.appendChild(title);
                    document.body.appendChild(f);
                    f.submit();
                        }
                    });  
                }
            }
            
            //checks if a value is a number
            function checkNumber(value) {
                return value % 1 == 0;
            }
        </script>
    </body>
</html>