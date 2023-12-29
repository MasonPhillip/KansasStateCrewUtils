<!--test administrator card -->
<?php 
    echo "<div class='col col-md-6 col-lg-3 mb-3 d-flex align-items-stretch'>";
    echo "  <div class='card' style='width: 18rem;'>";
    echo "      <img src='../images/testAdmin.jpg' class='card-img-top' alt='Workout Image'>";
    echo "      <div class='card-body'>";
    echo "          <h5 class='card-title'>Test Administrator</h5>";
    echo "          <p class='card-text'>Run a test for your team. Set your teams distance and goals, and record their results</p>";
    echo "          <a href='javascript: testAdministrator()' class='btn' style='background-color: #52307c'>View</a>";
    echo "      </div>";
    echo "  </div>";
    echo "</div>";
 ?>  
    <script>
        function testAdministrator(){
            var f = document.createElement("form");
            f.action="../testAdministrator.php";
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