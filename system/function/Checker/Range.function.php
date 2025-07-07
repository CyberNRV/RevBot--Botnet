<?php
    function CheckerRange($value = '0', $min = "",$max = ""){
        if(!is_numeric(@$value) OR !is_numeric($min) OR is_numeric($max)){
            return false;
        }
        if($value < $min){
            return false;
        }
        if($value > $max){
            return false;
        }
        return true;
    }


?>