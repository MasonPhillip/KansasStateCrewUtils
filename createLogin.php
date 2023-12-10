<html lang="en" data-bs-theme="dark">
<head>
		<title>New Login</title>
		    <title> <?php echo $title; ?></title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    
     <div class="d-flex justify-content-center">
         <h1 class="display-1">Create Account</h1>
    </div>
    

    <div class="d-flex justify-content-center">
        <div class="input-group mb-3 w-50">
            <div class="input-group-prepend">
                <span class="input-group-text bg-primary" id="basic-addon3">Name</span>
            </div>
            <input type="text" class="form-control" id="nameBox" name="nameBox" aria-describedby="basic-addon3"><p class="text-danger" id="nameWarning">*</p>
        </div>
    </div>

    <br>
    <div class="d-flex justify-content-center">
        <div class="input-group mb-3 w-50">
            <div class="input-group-prepend">
                <span class="input-group-text bg-primary" id="basic-addon3">Discord</span>
            </div>
            <input type="text" class="form-control" id="discordBox" name="discordBox" aria-describedby="basic-addon3"><p class="text-danger" id="discordWarning">*</p>
        </div>
    </div>

    <br>
    <div class="d-flex justify-content-center">
        <div class="input-group mb-3 w-50">
            <div class="input-group-prepend">
                <span class="input-group-text bg-primary" id="basic-addon3">Team Code</span>
            </div>
            <input type="text" class="form-control" id="teamBox" name="teamBox" aria-describedby="basic-addon3"><p class="text-danger" id="teamWarning">*</p>
        </div>
    </div>

    <br>
    <div class="d-flex justify-content-center">
        <div class="input-group mb-3 w-50">
            <div class="input-group-prepend">
                <span class="input-group-text bg-primary" id="basic-addon3">Password</span>
            </div>
            <input type="password" class="form-control" id="passwordBox" name="passwordBox" aria-describedby="basic-addon3">*<p class="text-danger" id="passwordWarning"></p>
        </div>
    </div>
    <div class="d-flex justify-content-center">
    <p>*Passwords must be at least 10 characters long</p>    
    </div>
    
    <br>
    <div class="d-flex justify-content-center">
        <div class="input-group mb-3 w-50">
            <div class="input-group-prepend">
                <span class="input-group-text bg-primary" id="basic-addon3">Confirm Password</span>
            </div>
            <input type="password" class="form-control" id="confirmPasswordBox" name="confirmPasswordBox" aria-describedby="basic-addon3"><p class="text-danger" id="confirmPasswordWarning">*</p>
        </div>
    </div>
    
    <div class="d-flex justify-content-center">
        <p class="text-danger">*required</p>
    </div
        
    <br>
    <div class="d-flex justify-content-center"> 
	<button id="loginBtn" class="btn btn-lg btn-primary" onClick='newLogin()'>Login</button>
    </div>
    
    
    <script>
        
        //handles the event when the user wants to create a new login
        function newLogin(){
            var name = document.getElementById('nameBox');
            var discord = document.getElementById('discordBox');
            var team = document.getElementById('teamBox');
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
            if(team.value == ""){
                document.getElementById('teamWarning').innerHTML = "*required";
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
        		xhttp.open("POST", "validateNewLogin.php");
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
                                f.action = "insertLogin.php";
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

