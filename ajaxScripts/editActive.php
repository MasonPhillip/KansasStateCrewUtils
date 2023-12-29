<?php
    include_once('../databaseCreds.php');
    $query = "UPDATE users SET isActive=".$_POST["active"]." WHERE ID=".$_POST["userId"];
    $conn->query($query);
    echo $query;
?>