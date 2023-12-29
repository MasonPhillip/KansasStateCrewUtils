<html lang="en" data-bs-theme="dark">
    <head>
		<title>New Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <?php include_once 'navBar.php';?>
         <br>
        
        <div class="row">
            <div class="col-1 col-lg-3"></div>
            <div class="col-12 col-md-12 col-lg-6 pb-3" style='border: solid 3px #AAA;'>
                <div class="d-flex justify-content-center">
                    <h1 class="display-1">Create Account</h1>
                </div>
        
                <div class="d-flex justify-content-center">
                    <div class="input-group mb-3 sm-w-100 w-75">
                        <div class="input-group-prepend">
                            <span class="input-group-text rounded-left" style='background-color: #52307c' id="basic-addon3">Name</span>
                        </div>
                        <input type="text" class="form-control rounded" id="nameBox" name="nameBox" aria-describedby="basic-addon3"><p class="text-danger" id="nameWarning">*</p>
                    </div>
                </div>
            
                <br>
                <div class="d-flex justify-content-center">
                    <div class="input-group mb-3 w-75">
                        <div class="input-group-prepend rounded-left">
                            <span class="input-group-text" style='background-color: #52307c' id="basic-addon3">Discord</span>
                        </div>
                        <input type="text" class="form-control rounded" id="discordBox" name="discordBox" aria-describedby="basic-addon3"><p class="text-danger" id="discordWarning">*</p>
                    </div>
                </div>
            
                <br>
            
                <br>
                <div class="d-flex justify-content-center">
                    <div class="input-group mb-3 w-75">
                        <div class="input-group-prepend rounded-left">
                            <span class="input-group-text" style='background-color: #52307c' id="basic-addon3">Password</span>
                        </div>
                        <input type="password" class="form-control rounded" id="passwordBox" name="passwordBox" aria-describedby="basic-addon3">*<p class="text-danger" id="passwordWarning"></p>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                <p>*Passwords must be at least 10 characters long</p>    
                </div>
                
                <br>
                <div class="d-flex justify-content-center">
                    <div class="input-group mb-3 w-75">
                        <div class="input-group-prepend rounded-left">
                            <span class="input-group-text" style='background-color: #52307c' id="basic-addon3">Confirm Password</span>
                        </div>
                        <input type="password" class="form-control rounded" id="confirmPasswordBox" name="confirmPasswordBox" aria-describedby="basic-addon3"><p class="text-danger" id="confirmPasswordWarning">*</p>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center">
                    <h6 class="text-danger ">*required</h6>
                </div
                    
                <br>
                <div class="d-flex justify-content-center"> 
            	    <button id="loginBtn" class="btn btn-lg" style='background-color: #52307c' onClick='newLogin()'>Login</button>
                </div>
            </div>
        </div>
        
        <script>
            
            //handles the event when the user wants to create a new login
            function newLogin(){
                var name = document.getElementById('nameBox');
                var discord = document.getElementById('discordBox');
                var team = document.createElement('teamBox');
                team.value = 0 <?php echo $_POST["teamId"]; ?>;
                var password = document.getElementById('passwordBox');
                var confirmPassword = document.getElementById('confirmPasswordBox');
                var cont = true;
                //verify that all the fields have information
                if(name.value == ""){
                    document.getElementById('nameWarning').innerHTML = "*required";
                    cont=false;
                }
                if(discord.value == ""){
                    document.getElementById('discordWarning').innerHTML = "*required";
                    cont=false;
                }
                if(password.value == ""){
                    document.getElementById('passwordWarning').innerHTML = "required";
                    cont=false;
                }
                else if(password.value.length < 12){
                    document.getElementById('passwordWarning').innerHTML = "must be at least 12 characters";
                }
                if(confirmPassword.value == ""){
                    document.getElementById('confirmPasswordWarning').innerHTML = "*required";
                    cont=false;
                }
                else if(confirmPassword.value != password.value){
                    alert("Passwords do not match!");
                    cont=false;
                }
                
                if(cont){
                    var xhttp = new XMLHttpRequest();
            		xhttp.open("POST", "ajaxScripts/validateNewLogin.php");
            		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    var attempted =0;
            		//how to handle the response
            		xhttp.onreadystatechange = () =>{
            			if(xhttp.status === 200){
            				attempted++;
                            if(attempted == 2){
                                var response = xhttp.responseText.split("|");
                                alert(response[0]+response[1]);
                                if(response[0] == "Team Not Found"){
                                    alert("Team Code Could Not be Found");
                                }
                                else if (response[1] == "name in use"){
                                    alert("Name Already In Use");
                                }
                                else{
                                    var f = document.createElement("form");
                                    team.value = response[0];
                                    f.action = "ajaxScripts/insertLogin.php";
                                    f.method= "post";
                                    f.appendChild(name);
                                    f.appendChild(discord);
                                    f.appendChild(team);
                                    f.appendChild(password);
                                    
                                    document.body.appendChild(f);
                                    f.submit();
                                }
                            }
                        }
            		}
                    //send the http response request
    		        xhttp.send("name="+name.value+"&team="+team.value);
                }
            }
            
            //make the enter key enter the form when the password is in the 
            var passBox = document.getElementById("passwordBox");
            passBox.addEventListener("keypress", function(event){
                if(event.key === "Enter"){
                    event.preventDefault();
                    document.getElementById("loginBtn").click();
                }
            });
        </script>
    
    </body>
</html>

