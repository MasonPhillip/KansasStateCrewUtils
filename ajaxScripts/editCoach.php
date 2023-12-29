<?php
    include_once('../databaseCreds.php');
    $query = "UPDATE users SET isCoach=".$_POST["coach"]." WHERE ID=".$_POST["userId"];
    $conn->query($query);
    echo $query;
?>