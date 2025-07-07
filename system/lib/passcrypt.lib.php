<?php
    class passcrypt{
        private $key = 'B9F74FAB27228A2F682777F7BE614';

    // Nouvelle méthode pour chiffrer une chaîne de caractères et renvoyer la valeur en base64
    function EncryptString($data) {
        $sSalt = $this->key;
        $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
        $method = 'aes-256-cbc';

        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

        $encrypted = base64_encode(openssl_encrypt($data, $method, $sSalt, OPENSSL_RAW_DATA, $iv));
        return $encrypted;
    }

    // Nouvelle méthode pour déchiffrer une valeur en base64 et renvoyer la chaîne de caractères
    function DecryptString($encrypted) {
        $sSalt = $this->key;
        $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
        $method = 'aes-256-cbc';

        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

        $decrypted = openssl_decrypt(base64_decode($encrypted), $method, $sSalt, OPENSSL_RAW_DATA, $iv);
        return $decrypted;
    }

        function Protect($password) {
            $sSalt = $this->key;
            $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
            $method = 'aes-256-cbc';
        
            $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        
            $encrypted = base64_encode(openssl_encrypt($password, $method, $sSalt, OPENSSL_RAW_DATA, $iv));
            return $encrypted;
        }
        
        function Check($encrypted,$uncrypted) {
            $sSalt = $this->key;
            $sSalt = substr(hash('sha256', $sSalt, true), 0, 32);
            $method = 'aes-256-cbc';
        
            $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        
            $decrypted = openssl_decrypt(base64_decode($encrypted), $method, $sSalt, OPENSSL_RAW_DATA, $iv);
          if($uncrypted == $decrypted){
              return true;
          }
        }
    }
?>