<html lang="en" data-bs-theme="dark">
    <?php 
        include_once "../databaseCreds.php"; //include db
    ?>
    <head>
    	<title>Workout Tracker</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
			
    <body>
        <?php include_once 'navBar.php'; //add navbar ?>
        <?php
        $isCoach = strval($_SESSION["isCoach"]);
        ?>
        <br>
        <div class="d-flex justify-content-center">
            <div class="row">
                <?php include_once 'pieceTrackerHomeCards/testHistoryCard.php';?>
                <?php if($isCoach == "1"){include_once 'pieceTrackerHomeCards/testAdministratorCard.php';}?>
                <div class="col col-md-6 col-lg-3 pl-3 mb-3 d-flex align-items-stretch">
                        <div class="card" style="width: 18rem;">
                            <img src="../images/homeImage.jpg" class="card-img-top" alt="Boat Image">
                            <br><br>
                            <div class="card-body">
                                <h5 class="card-title">Video Comments</h5>
                                <p class="card-text">Create and read commments on technique on videos from Google Drive or YouTube</p>
                                
                                <a href="login.php?mode=2" class="btn" style='background-color: #52307c'>Login</a>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6 col-lg-3 pl-3 mb-3 d-flex align-items-stretch">
                        <div class="card" style="width: 18rem;">
                            <img src="../images/homeImage.jpg" class="card-img-top" alt="Boat Image">
                            <br><br>
                            <div class="card-body">
                                <h5 class="card-title">Video Comments</h5>
                                <p class="card-text">Create and read commments on technique on videos from Google Drive or YouTube</p>
                                
                                <a href="login.php?mode=2" class="btn" style='background-color: #52307c'>Login</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        
    </body>
</html>