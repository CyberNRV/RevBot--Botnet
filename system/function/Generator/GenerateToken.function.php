<?php
    function GenerateToken(string $prefix = ""){
        $token = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, "20");
        if(!empty($prefix)){
            $token = $prefix.$token;
        }
        return $token;
    }
?>