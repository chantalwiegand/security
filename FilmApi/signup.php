<?php

//
//
////if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
////    header("Location: https://ntang.gcmediavormgeving.nl/security/login.php", true);
////    exit();
////}
//
//
//// if($_SERVER["REQUEST_METHOD"] == "POST"){
////     signup($_POST["username"], $_POST["password"], $_POST[["file"]]);
//// }
//if($_SERVER["REQUEST_METHOD"] == "POST"){
//
//
//
//    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//    $randomString = '';
//    $n=10;
//
//    for ($i = 0; $i < $n; $i++) {
//        $index = rand(0, strlen($characters) - 1);
//        $randomString .= $characters[$index];
//    }
//
//
//    $file_name = $randomString;
//    $file_size = $_FILES['file']['size'];
//    $file_tmp = $_FILES['file']['tmp_name'];
//    $file_type = $_FILES['file']['type'];
//    $file_ext = strtolower(end(explode('.', $_FILES['file']['name'])));
//    $username = $_POST["username"];
//    $password = $_POST["password"];
//
//    $extensions = array("jpeg", "jpg", "png");
//
//    if (in_array($file_ext, $extensions) === false) {
//        echo "This file type is not allowed. We allow: jpeg, jpg and png.";
//    }
//
//    if ($file_size > 2097152) {
//        echo 'File size must be excately 2 MB';
//    }
//
//    if (empty($errors) == true) {
//        // echo "komt er in!";
//        move_uploaded_file($file_tmp, "images/" . $file_name);
//
//
//
// //Maak verbinding met database
// $host = 'localhost';
// $dbuser = 'cwiegand_security';
// $dbpass = 'Testwachtwoord123!';
// $dbname = 'cwiegand_security';
// $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
//    if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}
//
//    $hashed_password =
//    password_hash($password, PASSWORD_DEFAULT);
//
//    $stmt = $conn->prepare('INSERT INTO users(username, password, profielfoto) VALUES (?, ?, ?)');
//    $stmt->bind_param("sss", $username, $hashed_password, $file_name);
//
//
//    $stmt->execute();
//    $stmt->close();
//    }
//}



//if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
//    header("Location: https://ntang.gcmediavormgeving.nl/security/login.php", true);
//    exit();
//}


// if($_SERVER["REQUEST_METHOD"] == "POST"){
//     signup($_POST["username"], $_POST["password"], $_POST[["file"]]);
// }
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    $n=10;

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }



    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));
    $file_name = $randomString .'.' . $file_ext;
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $profielfoto = $randomString .'.' . $file_ext;
    echo $profielfoto;
//    $email = $_POST["email"];

    $extensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $extensions) === false) {
        echo "This file type is not allowed. We allow: jpeg, jpg and png.";
    }

    if ($file_size > 2097152) {
        echo 'File size must be excately 2 MB';
    }

    if (empty($errors) == true) {
        // echo "komt er in!";
        move_uploaded_file($file_tmp, "images-folder/" . $file_name);



 //Maak verbinding met database
 $host = 'localhost';
 $dbuser = 'cwiegand_security';
 $dbpass = 'Testwachtwoord123!';
 $dbname = 'cwiegand_security';
 $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare('INSERT INTO users(username, email, password, profielfoto) VALUES (?, ?, ?,?)');
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $profielfoto);


    $stmt->execute();
    $stmt->close();
    }
}
?>



<?php
// if (isset($_FILES['image'])) {
//     $host = 'localhost';
//     $dbuser = 'cwiegand_security';
//     $dbpass = 'Testwachtwoord123!';
//     $dbname = 'cwiegand_security';
//     $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }


//     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//     $randomString = '';
//     $n=10;

//     for ($i = 0; $i < $n; $i++) {
//         $index = rand(0, strlen($characters) - 1);
//         $randomString .= $characters[$index];
//     }


//     $file_name = $randomString;
//     $file_size = $_FILES['image']['size'];
//     $file_tmp = $_FILES['image']['tmp_name'];
//     $file_type = $_FILES['image']['type'];
//     $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));
//     $username = $_POST["username"];
//     $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

//     $extensions = array("jpeg", "jpg", "png");

//     if (in_array($file_ext, $extensions) === false) {
//         echo "This file type is not allowed. We allow: jpeg, jpg and png.";
//     }
// if ($stmt = $conn->prepare("SELECT username FROM users WHERE username=?")) {
//     $stmt->bind_param("s", $username);

//     $stmt->execute();

//     $stmt->bind_result($result);

//     var_dump($result);
//     die();
    
//     $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
// }
// //    echo 'xcdbhjsnc jdcn';

// //    if ($file_size > 2097152) {
// //        echo 'File size must be excately 2 MB';
// //    }
// //    die();

//     if (empty($errors) == true) {
//         move_uploaded_file($file_tmp, "images-folder/" . $file_name);
// //        echo "<img src='images-folder/" . $file_name . "' alt='foto'>";
// //        $query = "INSERT INTO users (username, password, profielfoto)
// //			  VALUES('$username', '$password', '$file_name')";
// //        $conn->query($query);
//         $conn->prepare("INSERT INTO users (username, password, profielfoto) VALUES (?, ?, ?)");
//         $conn->bind_param("sss", $username, $password, $file_name);
//         $conn->close();


//     }

// }

?>


<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign up</title>
    <!--Externe stylesheets-->
    <link href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/4.1/examples/sign-in/signin.css" rel="stylesheet">
</head>

<body class="text-center">
<form action="signup.php" method="post" class="form-signin" enctype="multipart/form-data">
    <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required
           autofocus>
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required
           autofocus>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
    <input type="file" id="inputFile" name="image" class="form-control" accept="image/*">
    <input type="submit" class="btn btn-lg btn-primary btn-block" name="reg_user" value="Register">
</form>

<script>
    if (location.protocol !== 'https:') {
        location.protocol = 'https:';
    }
</script>

</body>
</html>