<?php
    function CYBERNRVPromoConvert($amount){
        if(!is_numeric($amount)){
            return false;
        }
        if($amount > 100){
           return false;
        }else{
            if($amount < 1){
                return false;
            }
        }
        $x = $amount / 100;
        return $x;
    }

?>