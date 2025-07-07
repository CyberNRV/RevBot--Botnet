<?php
    function CheckPasswordStrength($password){
        if (strlen($password) < 12) {
           return false;
        }
        if (!preg_match("#[0-9]+#", $password)) {
            return false;
        }
        if (!preg_match("#[a-zA-Z]+#", $password)) {
            return false;
        }     
        return true;
    }
?>