<?php



if (isset($_POST["submit"])){

    $host = 'localhost';
    $dbuser = 'cwiegand_security';
    $dbpass = 'Testwachtwoord123!';
    $dbname = 'cwiegand_security';
    $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "https://cwiegand.gcmediavormgeving.nl/security/les_6/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;

    $userEmail = $_POST["email"];

    $stmt = $conn->prepare('DELETE FROM password_reset WHERE email=?');
    $stmt->bind_param("s", $userEmail);


    $stmt->execute();
    $stmt->close();



    $stmt = $conn->prepare('INSERT INTO password_reset(email, selector, token, expires) VALUES (?, ?, ?,?)');

    $hashedToken = password_hash($token, PASSWORD_DEFAULT);

    $stmt->bind_param("ssss", $userEmail, $selector, $hashedToken, $expires);


    $stmt->execute();
    $stmt->close();


    $to = $userEmail;

    $subject = "Reset your password";

    $message = '<p> We recieved a password reset request, The link to reset your password is down below. 
                    If you did not make this request you can ignore this email</p>';
    $message .= '<br>Here is your password reset link: <br>';
    $message .= '<a href="'.$url.'">'. $url. '</a></p>';

    $headers = "From: Chantal <chantal.wiegand@student.graafschapcollege.nl>\r\n";
    $headers .= "Reply-To: chantal.wiegand@student.graafschapcollege.nl\r\n";
    $headers .= "Content-type: text/html\r\n";

    mail($to, $subject, $message, $headers);

    header("location: reset-password.php?reset=succes");



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
<h1>Reset your password</h1>
<form action="reset-password.php" method="post" class="form-signin">
    <input type="text" id="inputEmail" name="email" class="form-control" placeholder="Enter your email..." required autofocus>
    <input name="submit"  type="submit" class="btn btn-lg btn-primary btn-block" value="Reset password">
</form>

<?php
if (isset($_GET['reset'])){
    if ($_GET["reset"] == "succes"){
        echo '<p> Check your email! </p>';
    }
};
?>

<!--<script>-->
<!--    if (location.protocol !== 'https:'){-->
<!--        location.protocol = 'https:';-->
<!--    }-->
<!--</script>-->
</body>
</html>