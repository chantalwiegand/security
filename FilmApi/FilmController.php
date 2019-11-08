<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('film.php');
include_once('JWT.php');


//var_dump($_SERVER);
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $jwt = new JWT();

    $user = $jwt->getData(substr($_SERVER["HTTP_AUTHORIZATION"], 7));


//    var_dump($user["authlvl"]);

    if ($user["authlvl"] == 1 || $user["authlvl"] == 2 || $user["authlvl"] == 3 || $user["authlvl"] == 4) {


        if (isset($_GET['id'])) {

            $host = 'localhost';
            $dbuser = 'cwiegand_security';
            $dbpass = 'Testwachtwoord123!';
            $dbname = 'cwiegand_security';
            $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }


            $stmt = $conn->prepare('SELECT * FROM films WHERE id=?;');

            $stmt->bind_param("i", $_GET['id']);

            /* execute query */
            $stmt->execute();

            $result = $stmt->get_result();
//            var_dump($result);
            $stmt->close();

            $array = [];

            foreach ($result as $results) {
                $film = new Film();
                $film->id = $results["id"];
                $film->titel = $results["titel"];
                $film->genre = $results["genre"];
                $film->kijkwijzer = $results["kijkwijzer"];
                $film->speelduur = $results["speelduur"];

                array_push($array, $film);
            }

//            var_dump($array);

            echo json_encode($array, JSON_PRETTY_PRINT);


        } else {
            $host = 'localhost';
            $dbuser = 'cwiegand_security';
            $dbpass = 'Testwachtwoord123!';
            $dbname = 'cwiegand_security';
            $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }


            //Vraag resultaat
            if ($stmt = $conn->prepare("SELECT * FROM films;")) {

                /* execute query */
                $stmt->execute();

                $result = $stmt->get_result();
//            var_dump($result);
                $stmt->close();

                $array = [];

                foreach ($result as $results) {
                    $film = new Film();
                    $film->id = $results["id"];
                    $film->titel = $results["titel"];
                    $film->genre = $results["genre"];
                    $film->kijkwijzer = $results["kijkwijzer"];
                    $film->speelduur = $results["speelduur"];

                    array_push($array, $film);
                }

//            var_dump($array);

                echo json_encode($array, JSON_PRETTY_PRINT);

            }
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {

    $jwt = new JWT();

    $user = $jwt->getData(substr($_SERVER["HTTP_AUTHORIZATION"], 7));

    if ($user["authlvl"] == 2 || $user["authlvl"] == 3 || $user["authlvl"] == 4) {

        $obj = json_decode(file_get_contents('php://input'));

        $film = new Film();
        $film->titel = $obj->titel;
        $film->genre = $obj->genre;
        $film->speelduur = $obj->speelduur;
        $film->kijkwijzer = $obj->kijkwijzer;


        $host = 'localhost';
        $dbuser = 'cwiegand_security';
        $dbpass = 'Testwachtwoord123!';
        $dbname = 'cwiegand_security';
        $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        $stmt = $conn->prepare('INSERT INTO films(titel, speelduur, kijkwijzer, genre) VALUES (?,?,  ?,?)');

        $stmt->bind_param("ssis", $film->titel, $film->speelduur, $film->kijkwijzer, $film->genre);


        $stmt->execute();
//        var_dump($stmt);
//        die();

        $stmt->close();
        echo "De film is opgeslagen";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $jwt = new JWT();

    $user = $jwt->getData(substr($_SERVER["HTTP_AUTHORIZATION"], 7));
    if ($user["authlvl"] == 4) {
        $host = 'localhost';
        $dbuser = 'cwiegand_security';
        $dbpass = 'Testwachtwoord123!';
        $dbname = 'cwiegand_security';
        $conn = new mysqli($host, $dbuser, $dbpass, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $obj = json_decode(file_get_contents('php://input'));


        $stmt = $conn->prepare('DELETE FROM films WHERE id = ?');

        $stmt->bind_param("i", $obj->id);


        $stmt->execute();
//        var_dump($stmt);
//        die();

        $stmt->close();

        echo "De film is verwijderd";

    }
}