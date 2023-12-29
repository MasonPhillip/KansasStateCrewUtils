<?php
    include_once '../databaseCreds.php';
    $query = "UPDATE teams SET code='".$_POST["code"]."' WHERE ID = ".$_POST["teamId"];
    $conn->query($query);
    echo "success";
?>