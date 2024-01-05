<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <title>Add Video</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Add Video</h2>
  <form action="ajaxScripts/insertVideo.php" method="post" id="f">
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="textbox" class="form-control" id="title" placeholder="Enter Video Thread Title" name="title">
    </div>
    <div class="form-group">
      <label for="url">url:</label>
      <input type="textbox" class="form-control" id="url" placeholder="Enter Video Url" name="url">
    </div>
    <div class="form-group">
      <label for="comment">Comment:</label>
      <input type="textbox" class="form-control" id="comment" placeholder="Enter comment" name="comment">
    </div>
    <input type="hidden" id="createdByID", name="createdByID" value=<?php echo "'".$_SESSION["userId"]."'"; ?>></input>
    
    <input type="button" class="btn btn-primary" value="Submit" onClick="validateAndSumbit()"></button>
  </form>
</div>

</body>
</html>

<script>
    
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