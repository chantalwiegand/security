<?php

class JWT {
    private static $salt = 'qwerty1234';
    function getNewToken() {
            $header = '{"typ":"JWT", "alg":"HS256"}';
            $header = base64_encode($header);
            $header = str_replace("=", "", $header);

            $payload = '{"id": 67, "username":"test", "authlvl":4}';
            $payload = base64_encode($payload);
            $payload = str_replace("=", "", $payload);

            $signature = hash_hmac("sha256", $header . "." . $payload, "qwerty1234");
            $signature = base64_encode($signature);
            $signature = str_replace("=", "", $signature);

            $jwt = $header . "." . $payload . "." . $signature;
            $token = "Bearer " . $jwt;

//            return $token;
            echo $token;
    }

    public static function getIfValid($token) {
         $tokenArray = explode(".",$token);
         $signature = base64_decode($tokenArray[2]);
         $hash = hash_hmac("sha256", $tokenArray[0]. ".".$tokenArray[1], static::$salt);
         return $hash == $signature;
    }

    public static function getData($token) {
        if (static::getIfValid($token)){
            $tokenArray = explode(".", $token);
            return json_decode(base64_decode($tokenArray[1]), true);

        } else {
            return false;
        }
    }

}
