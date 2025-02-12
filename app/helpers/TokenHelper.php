<?php 
class TokenHelper{
    public static function generateToken($length = 32){
        return bin2hex(random_bytes($length));
    }

    //generate expiry date
    public static function generateExpiryDate(){
        return date('Y-m-d H:i:s', strtotime('+1 hour'));
    }

    //validate token, check if token is expired
    public static function validateToken($token, $expiryDate){
        return (strtotime($expiryDate) > time()) ? true : false;
    }
}
?>