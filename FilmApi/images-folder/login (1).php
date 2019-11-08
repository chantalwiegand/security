<?php

if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
    header("Location: https://cwiegand.gcmediavormgeving.nl/security/les_1/login.php", true);
    exit();
}

//Als loginformulier reeds werd verzonden
if($_SERVER["REQUEST_METHOD"] == "POST"){
    login($_POST["username"], $_POST["password"]);
}


function login($username, $password){
    //Maak verbinding met database
    $host = 'localhost';
    $dbuser = 'cwiegand_security';
    $dbpass = 'Testwachtwoord123!';
    $dbname = 'cwiegand_security';
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}


    //Vraag resultaat
    $sql = 'SELECT * FROM users WHERE username = "'.$username .'" AND password ="'.$password.'";';
    $result = $conn->query($sql);

    //Sluit verbinding met database
    $conn->close();


    //Onderneem actie op basis van resultaat
    if ($result->num_rows == 0) {
        echo "<script>alert('Incorrecte gegevens!');</script>";
    } else {
        echo "<script>alert('Succes!');</script>";
    }

    echo $result;
}
?>


<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!--Externe stylesheets-->
    <link href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/4.1/examples/sign-in/signin.css" rel="stylesheet">
</head>

<body class="text-center">
<form action="login.php" method="post" class="form-signin">
    <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required autofocus>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
    <input  type="submit" class="btn btn-lg btn-primary btn-block" value="Login">
</form>

<script>
    if (location.protocol !== 'https:'){
        location.protocol = 'https:';
    }
</script>

</body>
</html>