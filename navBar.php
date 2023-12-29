<head>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
       .navLogo {
   max-width: 100px; 
   height: auto; 
 }
  </style>
</head>

<?php //contains the navbar so it can be easily included and edited on all pages
//since the home page is html and it has to be, the navbar on hte home page must be updated manually
echo "<div class='sticky-top'><nav class='navbar navbar-expand-sm' style='background-color: #52307c;'><div class='container-fluid'><img src='../images/crest.png' class='navLogo' alt='logo'><div class='d-flex justify-content-center'><h3 class='display-3'>Kansas State Crew Utils <h3></div><!-- Links --><ul class='navbar-nav'><li class='nav-item'><a class='nav-link' href='javascript: openWorkoutTracker();'>Workout Tracker</a></li><li class='nav-item'><a class='nav-link' href='javascript: openVideoApp();'>Videos</a></li><li class='nav-item'><a class='nav-link' href='javascript: openAccount();'>Account</a></li></ul></div></nav>";
echo "</div>"

?>

<script>

    function openWorkoutTracker(){
        var f = document.createElement("form");
        f.action = "pieceTrackerHome.php";
        f.method="POST";
        var userID = document.createElement("input");
        userID.type = "hidden";
        userID.Id= "userId";
        userID.name = "userId";
        userID.value = <?php echo "0".$_POST["userId"]; ?>;
        f.appendChild(userID);
        document.body.appendChild(f);
        f.submit();
    }
    function openVideoApp(){
        var f = document.createElement("form");
        f.action = "videos.php";
        f.method="POST";
        var userID = document.createElement("input");
        userID.type = "hidden";
        userID.Id= "userId";
        userID.name = "userId";
        userID.value = <?php echo "0".$_POST["userId"]; ?>;
        f.appendChild(userID);
        document.body.appendChild(f);
        f.submit();
    }
    
    function openAccount(){
        var f = document.createElement("form");
        f.action = "editAccount.php";
        f.method="POST";
        var userID = document.createElement("input");
        userID.type = "hidden";
        userID.Id= "userId";
        userID.name = "userId";
        userID.value = <?php echo "0".$_POST["userId"]; ?>;
        f.appendChild(userID);
        document.body.appendChild(f);
        f.submit();
    }
</script>