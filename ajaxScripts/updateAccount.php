<?php
    include_once('../databaseCreds.php');
    $query = "";
    session_start();
    if($_POST["passwordBox"] == " "){
        $query = "UPDATE users SET discordHandle = '".htmlspecialchars($_POST["discordBox"])."' WHERE ID='".$_SESSION["userId"]."';";
    }
    else{
        $query = "UPDATE users SET discordHandle = '".htmlspecialchars($_POST["discordBox"])."', password='".htmlspecialchars($_POST["passwordBox"])."' WHERE ID='".$_SESSION["userId"]."';";
    }
    $conn->query($query);
?>

<body>
    <form action="../editAccount.php" method="POST" id='f'></form>
</body>
<script>
document.getElementById("f").submit();
</script>