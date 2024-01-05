<?php
    include_once '../databaseCreds.php';
    $SESSION_START();
    $query = "UPDATE teams SET code='".$_POST["code"]."' WHERE ID = ".$_SESSION["teamId"];
    $conn->query($query);
    echo "success";
?>