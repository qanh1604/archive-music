<?php
namespace App\Helpers;
class Hash{
    public static function openssl_encrypt($textToEncrypt){
        date_default_timezone_set('UTC');
        $encryptionMethod = "AES-256-CBC";
        $secret = "My32charPasswordAndInitVectorStr";  //must be 32 char length
        $iv = substr($secret, 0, 16);
        return openssl_encrypt($textToEncrypt, $encryptionMethod, $secret,0,$iv);
    }
    public static function openssl_decrypt($encryptedMessage){
        date_default_timezone_set('UTC');
        $encryptionMethod = "AES-256-CBC";
        $secret = "My32charPasswordAndInitVectorStr";  //must be 32 char length
        $iv = substr($secret, 0, 16);
        return openssl_decrypt($encryptedMessage, $encryptionMethod, $secret,0,$iv);
    }
}