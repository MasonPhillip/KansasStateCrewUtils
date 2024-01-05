//set store the name and password boxes in vars
    		var password = document.getElementById("passwordBox").value;
    		var name = document.getElementById("nameBox").value;
            
    
            //if one of the fields are blank the login button doesn't do anything
            if(name == "" || password == ""){
                return 0;
            }
            
            //create a new xml http request
    		var xhttp = new XMLHttpRequest();
    		xhttp.open("POST", "ajaxScripts/attemptLogin.php");
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
        						var userId = document.createElement('input');
        						userId.type='hidden';
        						userId.setAttribute("name", "userId");
        						userId.setAttribute("id", "userId");
        						userId.setAttribute("value", xhttp.responseText.slice(11));
        						var c2Auth = document.createElement('input');
        						c2Auth.type='hidden';
        						c2Auth.setAttribute("name", "c2Auth");
        						c2Auth.setAttribute("id", "c2Auth");
        						c2Auth.setAttribute("value", '<?php echo $_GET["code"]; ?>');
        						form.appendChild(c2Auth);
        						document.body.appendChild(form);
        						form.submit();
    						}
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