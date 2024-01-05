<html lang="en" data-bs-theme="dark">
    <?php
        //incluce the db conn
        include_once('databaseCreds.php');
    ?>



    <head>
        <title>Videos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </head>


    <body>
        <?php include_once 'navBar.php'; //add navbar ?>
        
        <?php
            $teamID = $_SESSION["teamId"];
            //select all the videos with a matching team id
            $query = "SELECT videos.ID, videos.url, videos.videoTitle, videos.lastCommentDate, users.name FROM videos INNER JOIN users ON videos.createdByUserID=users.ID where users.teamID ='".$teamID."' ORDER BY videos.lastCommentDate DESC;";
            $videos = $conn->query($query);
            $first = $videos->fetch_assoc();// get the most recent video so we can display it in a special way
            ?>
        <br>
        
        
        
        <!-- Embed the first video at the top of the page -->
        <div class="d-flex justify-content-center">
            <div class="card" style="width: 50rem;">
                <!-- Show the name of the first video at the top of the page -->
                <h6 class="display-6 text-center"><?php echo $first["videoTitle"]; ?></h6>
                <div class="d-flex justify-content-center pt-3">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src=<?php echo $first["url"]."/preview"; ?>; width="640" height="480" allow="autoplay"></iframe>
                    </div>
                </div>
                
                <?php 
                    $query = "SELECT v.comment, u.name FROM comments AS v JOIN users AS u ON v.userID = u.ID  WHERE v.videoID ='".$first["ID"]."'ORDER BY v.ID DESC LIMIT 1"; //get the most recent comment from there
                    $comment= $conn->query($query)->fetch_assoc();
                ?>
                <br>
                <!--Add a card with the most recent comment -->
                <div class="d-flex justify-content-center">
                     <?php echo "<div class='card w-75 mb-3'><div class='card-header'>".$comment["name"]."</div><div class='card-body'><blockquote class='blockquote mb-0'><p>".$comment["comment"]."</p></blockquote></div></div>"; ?>
                </div>
                
                <!-- Add a spot to reply here -->
                <div class='d-flex justify-content-center'>
                    <div style="width: 75%;">
                        <div class="input-group input-group-lg"><textarea class="form-control" aria-label="With textarea" id="commentBox" placeholder="Reply Here"></textarea><button class="btn" style='background-color: #52307c; text-color: #aaa;' type="button" id="button-addon2" onClick="addComment()">Reply</button></div>
                    </div>
                </div>
                
                <!--Add a button with the to open the video with the most recent comment-->
                <br>
                <div class="d-flex justify-content-center">
                    <button id='<?php echo $first["ID"];?>' class='btn btn-lg mb-3', onClick='openVideo(this)' style='background-color: #52307c; text-color: #aaa;' class='btn'>See More</button>
                </div>
                
            </div>
        </div>
        <br>
        
        <div class="container"></div>
            <div class="row">
                <!-- some empty space on the left -->
                <div class="col col-sm-12 col-md-1"></div>
                <!-- a column that takes most of the page in the middle that contains a table with all the videos -->
                <div class="col col-sm-12 col-md-8">
                    <div class="d-flex justify-content-center">
                        <div class="card w-100 pl-3">
                            <h2 class="text-center">More Videos</h2>
                            <div class="d-flex justify-content-center">
                                <table class="table table-striped table-bordered table-responsive w-75">
                                    <thead>
                                        <tr>
                                            <!-- table headers -->
                                            <th scope="col" class='text-center'> Video </th>
                                            <th scope="col" class='text-center'>Created By</th>
                                            <th scope="col" class='text-center'>Last Comment Date</th>
                                            <th scope="col" class='text-center'>Open</th>
                                        </tr>
                                    </thead>
                                    <?php
                                        while($row = $videos->fetch_assoc()){ //for all the rows in the result from the query
                                            echo "<tr>"; //open row
                                                echo "<td class='text-center'><a href='".$row["url"]."'>".$row["videoTitle"]."</a></td>"; //insert the video title into col 1
                                                echo "<td class='text-center'>".$row["name"]."</td>"; //but who crated the video in column 2
                                                echo "<td class='text-center'>".$row["lastCommentDate"]."</td>"; //put the date of the last comment in column 3
                                                echo "<td class='text-center'><button style='background-color: #52307c; text-color: #aaa;' class='btn' id='".$row["ID"]."'  onClick='openVideo(this)'>Open</button></td>"; //put the buutton to open that video in column 4
                                            echo "</tr>"; //close the current row
                                        }
                                    ?>
                                </table>
                            </div>
                         </div>
                     </div>
                </div>
                <!-- A spot to add a new video on the right -->
                <div class="col col-sm-12 col-md-3">
                    <div class="card w-75">
                        <h2 class="text-center">Add Video</h2>
                        <form action="ajaxScripts/insertVideo.php" method="post" id="f">
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="textbox" class="form-control" id="title" placeholder="Enter Video Thread Title" name="title">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="url">URL:</label>
                                <input type="textbox" class="form-control" id="url" placeholder="Enter Video Url" name="url">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="comment">Comment:</label>
                                <input type="textbox" class="form-control mb-3" id="comment" placeholder="Enter comment" name="comment">
                                </div>
                            <div class="d-flex justify-content-center">
                                <input type="button" style='background-color: #52307c; text-color: #aaa;' class='btn' value="Submit" onClick="validateAndSumbit()"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </body>

    <script>
        //Handles the event the open button in the table or video is pressed
        //should be passed the button iteslf whose ID matches it's associated video id
        function openVideo(btn){
            //create a form to submit
            var form = document.createElement('form');
            form.action = "videoComments.php";
            form.method='POST';
            //create another hidden input that stores the video id to be recieved from post in the next page
            var videoId = document.createElement('input');
            videoId.type='hidden';
            videoId.setAttribute("name", "videoID");
            videoId.setAttribute("id", "videoID");
            videoId.setAttribute("value", btn.id)
            form.appendChild(videoId);
            //add the form to body
            document.body.appendChild(form);
            form.submit();//submit the form
        }
        
        //when the user clicks enter add the comment to the page and refresh the page with a new comment
        function addComment(){
            var comment = document.getElementById("commentBox").value;
            if(comment != ""){
                $.ajax({
                   method: "POST",
                   url: "ajaxScripts/insertComment.php",
                   data: {
                       videoID: <?php echo $first["ID"]; ?>,
                       comment: comment
                   },
                   success: function(data){
                       alert(data);
                       location.reload();
                   }
                });
            }
        }
        
        //validates the data and adds the video
        function validateAndSumbit(){
            console.log(document.getElementById("title").value);
            if(document.getElementById("title").value == ""){
                alert("Please Enter A Video Title");
            }
            else if(document.getElementById("url").value == ""){
                alert("Please Enter a Url");
            }
            else if(document.getElementById("comment").value == ""){
                alert("Please Enter A Comment");
            }
            else{
                document.getElementById("f").submit();
            }
        }
    </script>
</html>