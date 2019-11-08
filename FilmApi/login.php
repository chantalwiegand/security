<?php
//if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
//    header("Location: https://ntang.gcmediavormgeving.nl/security/login.php", true);
//    exit();
//}
require_once ("JWT.php");

//Als loginformulier reeds werd verzonden
if($_SERVER["REQUEST_METHOD"] == "POST"){
    login($_POST["username"], $_POST["email"], $_POST["password"]);
}

function login($username, $email, $password){
    $jwt = new JWT();
    //Maak verbinding met database
    $host = 'localhost';
    $dbuser = 'cwiegand_security';
    $dbpass = 'Testwachtwoord123!';
    $dbname = 'cwiegand_security';
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}



    //Vraag resultaat
    if ($stmt = $conn->prepare("SELECT * FROM users WHERE username=?  ;")) {

        /* bind parameters for markers */
        $stmt->bind_param("s", $username);
        /* execute query */
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        // echo $result['password'];
        // echo "<br>";
        // echo password_hash($password, PASSWORD_DEFAULT);
        // echo "<br>";

//        var_dump($result);

        if (password_verify($password, $result['password'])) {
            $jwt->getNewToken();
//            var_dump($jwt);
            echo "<img src='images-folder/".$result['profielfoto']."' alt='profielfoto' /> ";

//get_declared_classes();
        }else {
            echo "Wrong data";
        }
        /* close statement */
        $stmt->close();
    }
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
<!--    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required >-->
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
    <input  type="submit" class="btn btn-lg btn-primary btn-block" value="Login">

    <?php
    if (isset($_GET["password"])){
        if ($_GET["password"] == "updated" ){
            echo '<p> Your password has been reset! </p>';
        }
    }
    ?>
    <p><a href="reset-password.php">Forgot password</a></p>
</form>

<!--<script>-->
<!--    if (location.protocol !== 'https:'){-->
<!--        location.protocol = 'https:';-->
<!--    }-->
<!--</script>-->
</body>
</html>