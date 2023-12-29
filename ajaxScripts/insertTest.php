<?php
    include_once '../databaseCreds.php';
    $userId = $_POST["userId"];
    $teamId = $_POST["teamId"];
    $distance = htmlspecialchars($_POST["distanceBox"]);
    $title = htmlspecialchars($_POST["titleBox"]);
    
    $query = "INSERT INTO tests (teamId, title) VALUES(".$teamId.", '".$title."');";
    echo $query;
    echo $distance;
    $conn->query($query);

?>
<html>
    <body>
        <script>
            var f = document.createElement("form");
            f.action = "../selectRowersForTest.php";
            f.method = "POST";
            
            var userId = document.createElement("input");
            userId.type = "hidden";
            userId.name = "userId";
            userId.value = 0<?php echo $userId;?>;
            
            var teamId = document.createElement("input");
            teamId.type = "hidden";
            teamId.name = "teamId";
            teamId.value = 0<?php echo $teamId;?>;
            
            var distance = document.createElement("input");
            distance.type = "hidden";
            distance.name = "distance";
            distance.value = <?php echo $distance;?>;
            
            var title = document.createElement("input");
            title.type = "hidden";
            title.name = "title";
            title.value = '<?php echo $title;?>';
            
            var testId = document.createElement("input");
            testId.type = "hidden";
            testId.name = "testId";
            testId.value = <?php echo $conn->insert_id; ?>;
            
            f.appendChild(userId);
            f.appendChild(teamId);
            f.appendChild(distance);
            f.appendChild(title);
            f.appendChild(testId);
            document.body.appendChild(f);
            f.submit();
            
        </script>
    </body>
</html>