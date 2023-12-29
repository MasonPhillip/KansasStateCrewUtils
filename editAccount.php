<?php
    include_once('databaseCreds.php'); //include db
    $query = "SELECT name, discordHandle, isCoach, c2AuthorizationCode AS c2Auth, teamId FROM users WHERE ID = ".$_POST["userId"].";";
    $person = $conn->query($query)->fetch_assoc();
?>
<html lang="en" data-bs-theme="dark">
    <head>
        <title>Account</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/2.0.0/sweetalert2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/2.0.0/sweetalert2.min.js"></script>
    </head>
    <body>
        <?php include_once 'navBar.php';?>
        <br>
        <div class="row">
            <div class="col-1 col-lg-3"></div>
                <div class="col-12 col-md-12 col-lg-6 pb-3" style='border: solid 3px #AAA;'>
                    <form action="ajaxScripts/updateAccount.php" method="POST" id="f">
                        <input type="hidden" id="userId" name="userId" value='<?php echo $_POST["userId"]; ?>'></input>
                    <div class="d-flex justify-content-center">
                        <h1 class="display-1">Edit Account</h1>
                    </div>
            
                    <div class="d-flex justify-content-center">
                        <div class="input-group mb-3 sm-w-100 w-75">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-left" style='background-color: #52307c' id="basic-addon3">Name</span>
                            </div>
                            <input type="text" class="form-control rounded" id="nameBox" name="nameBox" aria-describedby="basic-addon3" value='<?php echo $person["name"]?>' disabled>
                        </div>
                    </div>
                
                    <br>
                    <div class="d-flex justify-content-center">
                        <div class="input-group mb-3 w-75">
                            <div class="input-group-prepend rounded-left">
                                <span class="input-group-text" style='background-color: #52307c' id="basic-addon3">Discord</span>
                            </div>
                            <input type="text" class="form-control rounded" id="discordBox" name="discordBox" aria-describedby="basic-addon3" value='<?php echo $person["discordHandle"]?>'>
                        </div>
                    </div>
    
                
                    <br>
                    <div class="d-flex justify-content-center">
                        <div class="input-group mb-3 w-75">
                            <div class="input-group-prepend rounded-left">
                                <span class="input-group-text" style='background-color: #52307c' id="basic-addon3">Password</span>
                            </div>
                            <input type="password" class="form-control rounded" id="passwordBox" name="passwordBox" aria-describedby="basic-addon3">*
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
                            <input type="password" class="form-control rounded" id="confirmPasswordBox" name="confirmPasswordBox" aria-describedby="basic-addon3">
                        </div>
                    </div>
                    </form>    
                    <br>
                    <div class="d-flex justify-content-center"> 
                        <button id="loginBtn" class="btn btn-lg" style='background-color: #52307c' onClick='editLogin()'>Submit</button>
                    </div>
                    <br>
                    <div class="d-flex justify-content-center"> 
                        <h6 id="connectedMessage"><?php if($person["c2Auth"] != null){echo 'You already connected a c2 account, but you can click below to update to a new c2 account';} ?></h6>
                    </div>
                    <div class="d-flex justify-content-center"> 
                        <button id="connectC2Btn" class="btn btn-lg" style='background-color: #003769; color: #b7bf10' onClick='openC2()'>Connect C2 Logbook Account</button>
                    </div>
                    <?php 
                        if($person["isCoach"] == '1'){
                            echo "<br><div class='d-flex justify-content-center'><button id='manageTeamBtn' class='btn btn-lg' style='background-color: #52307c' onClick='openManageTeam()'>ManageTeam</button></div>";
                        }
                    ?>
                    
                </div>
                <br>
        </div>
       
       <script>
           function editLogin(){
                if(document.getElementById("passwordBox").value == ""){
                    document.getElementById("passwordBox").value = " ";
                    document.getElementById("f").submit();
                }
                else if(document.getElementById("passwordBox").value.length < 10){
                    alert("Password must be at least 10 characters long");
                }   
                else if(document.getElementById("passwordBox").value != document.getElementById("confirmPasswordBox").value){
                    alert("Passwords do not match");
                }
                else{
                    swal({
                        title: 'Please Confirm?', confirmButtonText: 'Confirm',
                        text: "",  
                        showCancelButton: true,
                        cancelButtonText: "Cancel "
                    }).then((isConfirm) => {
                        if (isConfirm) {
                            document.getElementById("f").submit();
				        }
			});  
                }
               
           }
           
           function openManageTeam(){
               var f = document.createElement("form");
               f.method = "POST";
               f.action = "manageTeam.php";
               f.appendChild(document.getElementById("userId"));
               document.createElement
               document.body.appendChild(f);
               var team = document.createElement("input");
               team.type = "hidden";
               team.value = 0<?php echo $person["teamId"];?>;
               team.name = "teamId";
               f.appendChild(team);
               f.submit();
           }
           
           function openC2(){
               window.open("https://log.concept2.com/oauth/authorize?client_id=QbCIpBcFVKGwRDTv1inr1oWf4QEWy6nJFzVgZzN8&scope=user:read,results:read&response_type=code&redirect_uri=https://kansasstatecrewutils.org/connectC2.php")
           }
           

       </script> 
    </body>
</html>