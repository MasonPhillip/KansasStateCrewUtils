<?php
    include_once('databaseCreds.php');
    $query = "SELECT U.ID as userID, U.name as name, C.comment as comment, V.url AS url, V.videoTitle AS  videoTitle FROM comments AS C JOIN users AS U on C.userID = U.ID JOIN videos AS V on V.ID = C.videoID WHERE C.videoId = ".$_POST["videoID"];
    $comments = $conn->query($query);
    $userID = $_SESSION["userID"];
    $first = $comments->fetch_assoc();
    $title = $first["videoTitle"];
    $url = $first["url"];
?>
<html lang="en" data-bs-theme="dark">
    <head>
        <title> <?php echo $title; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </head>

    <body>
        <?php include_once 'navBar.php'; //add navbar ?>
        <div class="d-flex justify-content-center">
            <!--create a title with the video title -->
            <h1><?php echo $title; ?></h1>
        </div>
        <div>
            <div class="d-flex justify-content-center">
                <!-- embed the video from google drive -->
                <iframe class="embed-responsive embed-responsive-16by9" src=<?php echo $url."/preview"; ?>; width="640" height="480" allow="autoplay"></iframe>
            </div>
            <br></br>
            <?php
                echo "<div class='d-flex justify-content-center'>";
                $thisUser="";
                if($first["userID"] == $userID){
                    $thisUser = "bg-primary";
                }
                echo "<div class='card w-75 ".$thisUser."'><div class='card-header'>".$first["name"]."</div><div class='card-body'><blockquote class='blockquote mb-0'><p>".$first["comment"]."</p></blockquote></div></div>";
                echo "</div>";
                
                while($comment = $comments->fetch_assoc()){
                    $thisUser="";
                if($comment["userID"] == $userID){
                    $thisUser = "bg-primary";
                }
                    echo "<div class='d-flex justify-content-center'>";
                echo "<div class='card w-75 ".$thisUser."'><div class='card-header'>".$comment["name"]."</div><div class='card-body'><blockquote class='blockquote mb-0'><p>".$comment["comment"]."</p></blockquote></div></div>";
                echo "</div>";
                }
            ?>
            <br></br>
            <div class='d-flex justify-content-center'>
                <div style="width: 75%;">
                    <div class="input-group input-group-lg"><span class="input-group-text"> Add Commment</span><textarea class="form-control" aria-label="With textarea" id="commentBox"></textarea><button class="btn btn-outline-primary" type="button" id="button-addon2" onClick="addComment()">Enter</button></div>
                </div>
            </div>
        </div>
    </body>

    <script>

        //make the enter key enter the form when the password is in the 
        var commentBox = document.getElementById("commentBox");
        commentBox.addEventListener("keypress", function(event){
         if(event.key === "Enter"){
            event.preventDefault();
            document.getElementById("button-addon2").click();
        }
        });
        
        //when the user clicks enter add the comment to the page and refresh the page with a new comment
        function addComment(){
            var comment = document.getElementById("commentBox").value;
            if(comment != ""){
                $.ajax({
                   method: "POST",
                   url: "ajaxScripts/insertComment.php",
                   data: {
                       videoID: <?php echo $_POST["videoID"]; ?>,
                       comment: comment
                   },
                   success: function(data){
                       alert(data);
                       location.reload();
                   }
                });
                
            }
        }
    </script>
</html>