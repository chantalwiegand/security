<?php

if (isset($_POST['submit'])){

    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $passwordrepeat = $_POST["password-repeat"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if (empty($password) || empty($passwordrepeat)){
        header("Location: create-new-password.php?password=empty");
        exit();
    } elseif ($password != $passwordrepeat){
        header("Location: create-new-password.php?password=different");
        exit();
    }

    $currentDate = date("U");

    $host = 'localhost';
    $dbuser = 'cwiegand_security';
    $dbpass = 'Testwachtwoord123!';
    $dbname = 'cwiegand_security';
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}


        $stmt = $conn->prepare("SELECT * FROM password_reset WHERE selector=? AND expires >= ? ;");

        /* bind parameters for markers */
        $stmt->bind_param("ss", $selector, $currentDate);
        /* execute query */
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();


        /* close statement */
        $stmt->close();

        $tokenBin = hex2bin($validator);

        $tokenCheck = password_verify($tokenBin, $result["token"]);

        if ($tokenCheck === false){
            echo "You need to re-submit";
            exit();
        } elseif ($tokenCheck === true){

            $tokenEmail = $result["email"];

            if ($stmt = $conn->prepare("SELECT * FROM users WHERE email=?")) {

                $stmt->bind_param("s", $tokenEmail);
                /* execute query */
                $stmt->execute();

                $result2 = $stmt->get_result()->fetch_assoc();



                /* close statement */
                $stmt->close();
            }

            $stmt = $conn->prepare('UPDATE users SET password=? WHERE email=?');
            $stmt->bind_param("ss", $hashed_password, $tokenEmail);


            $stmt->execute();

            $stmt->close();

            $stmt = $conn->prepare('DELETE FROM password_reset WHERE email=?');
            $stmt->bind_param("s", $tokenEmail);


            $stmt->execute();

            $stmt->close();


            header("Location: login.php?password=updated");
            exit();



        }



}

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset Password</title>
    <!--Externe stylesheets-->
    <link href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/4.1/examples/sign-in/signin.css" rel="stylesheet">
</head>
<body class="text-center">
<h1>Create new password</h1>
<?php
$selector = $_GET["selector"];
$validator = $_GET["validator"];
if (!isset($_POST['submit'])) {
    if (empty($selector) || empty($validator)) {
        echo "We could not validate your request";
    } else {
        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
            ?>

            <form action="create-new-password.php" method="post" class="form-signin">
                <input type="hidden" name="selector" value="<?php echo $selector ?>">
                <input type="hidden" name="validator" value="<?php echo $validator ?>">
                <input type="password" id="inputPassword" name="password" class="form-control"
                       placeholder="Enter a new password..." required autofocus>
                <input type="password" id="inputPasswordRepeat" name="password-repeat" class="form-control"
                       placeholder="Repeat new password..." required autofocus>
                <input name="submit" type="submit" class="btn btn-lg btn-primary btn-block" value="Reset password">
            </form>

            <?php
        }
    }
}
?>


<!--<script>-->
<!--    if (location.protocol !== 'https:'){-->
<!--        location.protocol = 'https:';-->
<!--    }-->
<!--</script>-->
</body>
</html>