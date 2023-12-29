<?php
    include_once '../databaseCreds.php'; //use the db
    //create a query to insert the data and then run it
    $query = "INSERT INTO teams (name, webhook, code) values ('".htmlspecialchars($_POST["nameBox"])."', '".htmlspecialchars($_POST["webhookBox"])."', '".htmlspecialchars($_POST["codeBox"])."');";
    $conn->query($query);
?>
<html>
    <body>
        <script>
            //inform the user then return to homescreen
             alert("Team Created");
             var f = document.createElement("form");
             f.action = "../createCoachLogin.php";
             f.method = "POST";
             var teamId = document.createElement("input");
             teamId.type = "hidden";
             teamId.id = "teamId";
             teamId.value = '<?php echo $conn->insert_id;?>';
             f.appendChild(teamId);
             
             document.body.appendChild(f);
             f.submit();
        </script>
    </body>
</html>
