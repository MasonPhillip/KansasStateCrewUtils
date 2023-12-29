<!--test history card -->
<?php 
    echo "<div class='col col-md-6 col-lg-3 mb-3 d-flex align-items-stretch'>";
    echo "  <div class='card' style='width: 18rem;'>";
    echo "      <img src='../images/workoutTrackerImage.jpg' class='card-img-top' alt='Workout Image'>";
    echo "      <div class='card-body'>";
    echo "          <h5 class='card-title'>Test History</h5>";
    echo "          <p class='card-text'>View Your Team's Test Histor</p>";
    echo "          <a href='javascript: testHistory()' class='btn' style='background-color: #52307c'>View</a>";
    echo "      </div>";
    echo "  </div>";
    echo "</div>";
 ?>  
    <script>
        function testHistory(){
            var f = document.createElement("form");
            f.action="../testHistory.php";
            f.method="POST";
            var userId = document.createElement('input');
        	userId.type='hidden';
        	userId.setAttribute("name", "userId");
        	userId.value = 0<?php echo $_POST["userId"];?>;
        	f.appendChild(userId);
        	document.body.appendChild(f);
        	f.submit();
            
        }
    </script>