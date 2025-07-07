<?php
    function TimestampAddMinutes($timestamp = "",$minutes = ""){
        if(!is_numeric($timestamp) OR !is_numeric($minutes)){
            echo "TimestampAddMinutes BUG";
             return time();
            }
        $time_add = (60 * $minutes);
        $final = $timestamp + $time_add;
            return $final;
    }
?>