<?php
    function CurlGet($link = "",$timeout = "5"){
        if(filter_var($link,FILTER_VALIDATE_URL) AND is_numeric($timeout)){
            $timeout = round($timeout);
            $url = $link;
            $ch = curl_init($url);
             curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
             curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            if(curl_errno($ch)){
              return false;
            }
            return $response;
        }
        return false;
    }
?>