<html lang="en" data-bs-theme="dark">
    <?php 
        include_once 'databaseCreds.php'; //use the db
        //get all the team names and codes since they have to be unique so we can put them in the js for validation
        $query = "SELECT name, code FROM teams";
        $teams = $conn->query($query);
        $names = array();
        $codes = array();
        while($team = $teams->fetch_assoc()){
            $names[] = $team["name"];
            $codes[] = $team["code"];
        }
    ?>
    <head>
        <title>Request Access</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    
    <body>
        <?php include_once 'navBar.php'; //add navbar ?>
        <br>
        <div class="row">
            <div class="col-1 col-lg-3"></div>
            <div class="col-12 col-md-12 col-lg-6 pb-3" style='border: solid 3px #AAA;'>
                <div class="d-flex justify-content-center">
                    <h1 class="display-1">Request Access</h1>
                </div>
        
                <div class="d-flex justify-content-center">
                    <div class="input-group mb-3 sm-w-100 w-75">
                        <div class="input-group-prepend">
                            <span class="input-group-text rounded-left" style='background-color: #52307c' id="basic-addon3">Team Name</span>
                        </div>
                        <input type="text" class="form-control rounded" id="nameBox" name="nameBox" aria-describedby="basic-addon3"><p class="text-danger" id="nameWarning">*</p>
                    </div>
                </div>
            
                <br>
                <div class="d-flex justify-content-center">
                    <div class="input-group mb-3 w-75">
                        <div class="input-group-prepend rounded-left">
                            <span class="input-group-text" style='background-color: #52307c' id="basic-addon3">Webhook</span>
                        </div>
                        <input type="text" class="form-control rounded" id="webhookBox" name="webhookBox" aria-describedby="basic-addon3"><p class="text-danger" id="webhookWarning">*</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center" style="text-align: center">
                    <div class="d-flex w-75">
                        <p>A webhook for the discord server you would like to be notified when an athlete adds a comment in the comment app</p>  
                    </div>
                </div>
            
                <br>
                <div class="d-flex justify-content-center">
                    <div class="input-group mb-3 w-75">
                        <div class="input-group-prepend rounded-left">
                            <span class="input-group-text rounded-left" style='background-color: #52307c' id="basic-addon3">Team Code</span>
                        </div>
                        <input type="text" class="form-control rounded" id="codeBox" name="codeBox" aria-describedby="basic-addon3"><p class="text-danger" id="codeWarning">*</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <p>A unique code that will let your athletes create an account within your team</p>    
                </div>
                
                <br>
            
                
                <div class="d-flex justify-content-center">
                    <h6 class="text-danger ">*required</h6>
                </div
                    
                <br>
                <div class="d-flex justify-content-center"> 
            	    <button id="requestBtn" class="btn btn-lg" style='background-color: #52307c' onClick='request()'>Request</button>
                </div>
            </div>
        </div>
        
        <script>
            function request(){
                var names = <?php echo json_encode($names); ?>;
                var codes = <?php echo json_encode($codes); ?>;
                var nameBox = document.getElementById('nameBox');
                var codeBox = document.getElementById('codeBox');
                var webhookBox = document.getElementById('webhookBox');
                var cont = 1;
                //validate the data
                if(nameBox.value == ""){
                    document.getElementById("nameWarning").innerHTML = "*required";
                    cont = 0;
                }
                if(codeBox.value == ""){
                    document.getElementById("codeWarning").innerHTML = "*required";
                    cont = 0;
                }
                if(webhookBox.value == ""){
                    document.getElementById("webhookWarning").innerHTML = "*required";
                    cont = 0;
                }
                if(names.includes(nameBox.value)){
                    document.getElementById("nameWarning").innerHTML = "name already in use";
                    cont = 0;
                }
                if(codes.includes(codeBox.value)){
                    document.getElementById("codeWarning").innerHTML = "code already in use";
                    cont = 0;
                }
                if(cont == 1){
                    //if the data is all valid, create a form that will insert the data and return to homescreen
                    var f = document.createElement("form");
                    f.action="ajaxScripts/insertTeam.php";
                    f.method="POST";
                    f.appendChild(nameBox);
                    f.appendChild(webhookBox);
                    f.appendChild(codeBox);
                    document.body.appendChild(f);
                    f.submit();
                }
            }
                
        </script>
    </body>
</html>