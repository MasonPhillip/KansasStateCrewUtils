<html lang="en" data-bs-theme="dark">
<?php
//init db vars
$servername = "localhost:3306";
$username = "i9673948_wp1";
$password = "abc12345";
$dbname = "i9673948_wp1";
$conn = mysqli_connect($servername, $username, $password, $dbname);

//run query
$query = "SELECT videos.ID, videos.url, videos.videoTitle, videos.lastCommentDate, users.name FROM videos INNER JOIN users ON videos.createdByUserID=users.ID ORDER BY videos.lastCommentDate DESC;";
$videos = $conn->query($query);

?>



<head>
    <title>Videos</title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>


<body>
    <div class="d-flex justify-content-center">
<button class="bg-primary" onclick="newVideo()">New Video</button>
</div>
<div class="d-flex justify-content-center">
    <table class="table table-striped table-bordered table-responsive w-75">
        <thead>
        <tr>
            <!-- table headers -->
            <th scope="col"> Video </th>
            <th scope="col">Created By</th>
            <th scope="col">Last Comment Date</th>
            <th scope="col">Open</th>
        </tr>
        </thead>
        <?php

while($row = $videos->fetch_assoc()){
    echo "<tr>";
    echo "<td><a href='".$row["url"]."'>".$row["videoTitle"]."</a></td>";
    echo "<td>".$row["name"]."</td>";
    echo "<td>".$row["lastCommentDate"]."</td>";
    echo "<td><button background-color: #967bb6;' id='".$row["ID"]."'  onClick='openVideo(this)'>Open</button></td>";
    echo "</tr>";
}

        ?>
    </table>
    </div>
</body>

<script>
    function openVideo(btn){
        var form = document.createElement('form');
		form.action = "videoComments.php";
		form.method='POST';
		var userId = document.createElement('input');
		userId.type='hidden';
		userId.setAttribute("name", "userID");
		userId.setAttribute("id", "userID");
		userId.setAttribute("value", <?php echo $_POST["userId"] ?>);
		form.appendChild(userId);
		var videoId = document.createElement('input');
		videoId.setAttribute("name", "videoID");
		videoId.setAttribute("id", "videoID");
		videoId.setAttribute("value", btn.id)
		form.appendChild(videoId);
		document.body.appendChild(form);
		form.submit();
    }
    
    function newVideo(){
        var form = document.createElement('form');
		form.action = "/newVideo.php";
		form.method='POST';
		var userId = document.createElement('input');
		userId.type='hidden';
		userId.setAttribute("name", "userID");
		userId.setAttribute("id", "userID");
		userId.setAttribute("value", <?php echo $_POST["userId"] ?>);
		form.appendChild(userId);
		document.body.appendChild(form);
		form.submit();
    }
    </script>