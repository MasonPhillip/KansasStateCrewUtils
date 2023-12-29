<?php
    include_once ('../databaseCreds.php');
    $query = "UPDATE users SET c2AuthorizationCode ='".$_POST["c2Auth"]."' WHERE ID = ".$_POST["userId"].";";
    $conn->query($query);
?>
<body></body>
<script>

        var f = document.createElement("form");
        f.action = "../editAccount.php";
        f.method="POST";
        var userID = document.createElement("input");
        userID.type = "hidden";
        userID.Id= "userId";
        userID.name = "userId";
        userID.value = <?php echo "0".$_POST["userId"]; ?>;
        f.appendChild(userID);
        document.body.appendChild(f);
        f.submit();
</script>