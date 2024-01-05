
<html lang="en" data-bs-theme="dark">
    <head>
    	<title>Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </head>
			
    <body>
        <br>
        <div class="container pb-3" style="border: solid 3px #aaa">
            <!-- Login Title -->
            <div class="d-flex justify-content-center">
                <h1 class="display-1">Login</h1>
            </div>
            <!-- since the c2 page returns to login, add this so the js on that page can display a message -->
            <div class="d-flex justify-content-center">
                <h6 id="returnDisplay"></h6>
            </div>
            <br>
            <!--name entry -->
            <div class="d-flex justify-content-center">
                <div class="input-group mb-3 w-75">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style='background-color: #52307c' id="basic-addon3">Name</span>
                    </div>
                    <input type="text" class="form-control" id="nameBox" name="nameBox" aria-describedby="basic-addon3">
                </div>
            </div>
    
            <br>
            <!-- Password Entry -->
            <div class="d-flex justify-content-center">
                <div class="input-group mb-3 w-75">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style='background-color: #52307c' id="basic-addon3">Password</span>
                    </div>
                    <input type="password" class="form-control" id="passwordBox" name="passwordBox" aria-describedby="basic-addon3">
                </div>
            </div>
            
            <!--Create Account Link -->
            <div class="d-flex justify-content-center">
                <a href=createLogin.php>Create Account</a>
            </div>
    
            <br>
    
            <!--Login Button-->
            <div class="d-flex justify-content-center">
    	        <button id="loginBtn" class="btn btn-lg" style='background-color: #52307c' onClick='loginAttempt()'>Login </button>
            </div>
        </div>
    </body>
    <script>
    
    
        //make the enter key enter the form when the password is in the 
        var passBox = document.getElementById("passwordBox");
        passBox.addEventListener("keypress", function(event){
            if(event.key === "Enter"){
                event.preventDefault();
                document.getElementById("loginBtn").click();
            }
        });
    
        //function to run when the login button is clicked
    	function loginAttempt(){
            //set store the name and password boxes in vars
    		var password = document.getElementById("passwordBox").value;
    		var name = document.getElementById("nameBox").value;
            
    
            //if one of the fields are blank the login button doesn't do anything
            if(name == "" || password == ""){
                return 0;
            }
            
            $.ajax({
                method: "POST",
                url: "ajaxScripts/attemptLogin.php",
                data:{
                    name: name,
                    password: password
                },
                success: function(data){
                    if(data.indexOf("accepted + ") >= 0){
                        var form = document.createElement('form');
                        //mode 1 means open the workout tracker
                        if(0<?php echo $_GET["mode"]; ?> == 1){
                            form.action = "/pieceTrackerHome.php";
                        }
                        else if(0<?php echo $_GET["mode"]; ?> == 2){
                            form.action = "/videos.php";
                        }
                        else if(0<?php echo $_GET["mode"]; ?> == 3){
                            form.action = "/editAccount.php";
                        }
                        
                        else if(0<?php echo $_GET["mode"]; ?> == 4){
                            form.action = "ajaxScripts/insertC2.php";
                            form.method='POST';
                            var c2Auth = document.createElement('input');
                            c2Auth.type='hidden';
                            c2Auth.setAttribute("name", "c2Auth");
                            c2Auth.setAttribute("id", "c2Auth");
                            c2Auth.setAttribute("value", '<?php echo $_GET["code"]; ?>');
                            form.appendChild(c2Auth);
                        }
                        form.method='POST';
                        var userId = document.createElement('input');
                        userId.type='hidden';
                        userId.setAttribute("name", "userId");
                        userId.setAttribute("id", "userId");
                        userId.setAttribute("value", data.slice(11));
                        form.appendChild(userId);
                        document.body.appendChild(form);
                        form.submit();
                    }
                    //if the username is valid but the password doesn't match alert the user and clear the password box
                    else if(data == "validName"){
                        alert("That password doesn't match that name");
                        document.getElementById("passwordBox").value = "";
                    }
                    //otherwise show that the name wasn't found and clear the password box
                    else{
                        alert("Name not found");
                        document.getElementById("passwordBox").value = "";
                    }
                }
                
            })
    	}
    
    
    </script>
</html>