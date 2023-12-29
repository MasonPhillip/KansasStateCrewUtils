<?php
    include_once('../databaseCreds.php');
    $query = "";
    if($_POST["passwordBox"] == " "){
        $query = "UPDATE users SET discordHandle = '".htmlspecialchars($_POST["discordBox"])."' WHERE ID='".$_POST["userId"]."';";
    }
    else{
        $query = "UPDATE users SET discordHandle = '".htmlspecialchars($_POST["discordBox"])."', password='".htmlspecialchars($_POST["passwordBox"])."' WHERE ID='".$_POST["userId"]."';";
    }
    $conn->query($query);
?>

<body>
    <form action="../editAccount.php" method="POST" id='f'><input type="hidden" value = '<?php echo $_POST["userId"]; ?>' name="userId"></input></form>
</body>
<script>
document.getElementById("f").submit();
</script>