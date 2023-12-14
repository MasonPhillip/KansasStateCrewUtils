<html>
    <head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
    <body>
        <button onClick="runAPI()">Click Me</button>
        <p id = "b"></p>
    </body>
    <script>
    function runAPI(){
        $.ajax({
            method: "GET",
            url: "https://log.concept2.com/api/users/me/results/",
            headers: {
                Authorization: "Bearer fqGGYSDckIfWpYvwXeI1ftUevP5rpb4TID16CxaP"
            },
            success: function (data){
                document.getElementById("b").innerHTML = JSON.stringify(data["data"][0]);
            }
        });
    }
</script>
</html>

