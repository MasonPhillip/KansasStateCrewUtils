
<html lang="en" data-bs-theme="dark">
<head>
		<title>Login</title>
		    <title> <?php echo $title; ?></title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
			
<body>
     <div class="d-flex justify-content-center">
         <h1>Login</h1>
         </div>

<div class="d-flex justify-content-center">
    <div class="input-group mb-3 w-50">
        <div class="input-group-prepend">
            <span class="input-group-text bg-primary" id="basic-addon3">Name</span>
        </div>
     <input type="text" class="form-control" id="nameBox" name="nameBox" aria-describedby="basic-addon3">
    </div>
</div>

<br>

<div class="d-flex justify-content-center">
    <div class="input-group mb-3 w-50">
        <div class="input-group-prepend">
            <span class="input-group-text bg-primary" id="basic-addon3">Password</span>
        </div>
     <input type="password" class="form-control" id="passwordBox" name="passwordBox" aria-describedby="basic-addon3">
    </div>
</div>


<div class="d-flex justify-content-center">
	<button id="loginBtn" class= "btn-lg" onClick='loginAttempt()'>Login </button>
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
        if(name == "" || password == ""){
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
						var form = document.createElement('form');
						form.action = "/videos.php";
						form.method='POST';
						var userId = document.createElement('input');
						userId.type='hidden';
						userId.setAttribute("name", "userId");
						userId.setAttribute("id", "userId");
						userId.setAttribute("value", xhttp.responseText.slice(11));
						form.appendChild(userId);
						document.body.appendChild(form);
						form.submit();
						//window.location.replace("videos.php");
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