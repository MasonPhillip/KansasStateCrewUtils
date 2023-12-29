<html lang="en" data-bs-theme="dark">
    <head>
    	<title>Connect C2</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
			
    <body>
        <script>
            var c2Auth = '<?php echo $_GET["code"];?>';
        </script>
        <?php
        $_GET["mode"] = 4;
        include_once("login.php");
        
        ?>
        <script>
            document.getElementById("returnDisplay").innerHTML= "Login to complete connecting to your c2 account";
        </script>
    </body>
</html>
