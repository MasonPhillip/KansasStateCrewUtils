<?php
echo $response;

?>

<style>

	body{
		background-color: #512888;
	}

	.centerBox{
		margin: auto;
		border: 3px solid #000;
		height: 200px;
		width: 375px;
		text-align: center;
		font-size: 30px;    
		font-weight: bold;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       %;
	}

	.loginButton{
		margin-top:2%;
		font-weight: bold;
		height: 30px;
		width: 70px;
		background-color: #967bb6
	}
	.header{
		font-weight:bold;
		font-size:50px;
		font-family: "Times New Roman", Times, serif;
		text-align: center;
	}
</style>
<head>
		<title>Login</title>
</head>
			
<body>
	<div class="header">Kansas State Crew Utils App</div>
	<div class="centerBox">
		<div style="margin-top: 12%;">
			Name
			<input type="textbox" style="margin: auto; height: 30px;" id="nameBox" name="nameBox"> </input>
		</div>
		<div style = "margin-top:2% ;">
			Password
			<input type="password" style="height: 30px;" id="passwordBox" name="passwordBox"> </input>
		</div>
		<input type="button" id="loginBtn" class= "loginButton" value = "Login" onClick='loginAttempt()'> </input>
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
        var attempted = 0;

        //if one of the fields are blank the login button doesn't do anything
        if(name == "" || passwordd == ""){
            return 0;
        }
        
        //create a new xml http request
		var xhttp = new XMLHttpRequest();
		xhttp.open("POST", "attemptLogin.php");
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		//how to handle the response
		xhttp.onreadystatechange = () =>{
			if(xhttp.status === 200){
				attempted++;
                if(attempted == 2){
                    //if the password and name are valid open the app and close this page
                    if(xhttp.responseText.indexOf("accepted + ") >= 0){
                        console.log('logged in');
                        console.log(xhttp.responseText);
                    }
                    //if the username is valid but the password doesn't match alert the user and clear the password box
                    else if(xhttp.responseText == "validName"){
                        alert("That password doesn't match that name");
                        document.getElementById("passwordBox").value = "";
                    }
                    //otherwise show that the name wasn't found and clear the password box
                    else{
                        alert("Name not found");
                        document.getElementById("passwordBox").value = "";
                    }
                }
			}
            
		}
        //send the http response request
		xhttp.send("name="+name+"&password="+password);
	}


</script>