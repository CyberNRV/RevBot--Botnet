<?php

    function StringLower($string = "",bool $cleaninput = true){
    
            if(empty($string)){
                return "";
            }
            //require CleanInput
            if($cleaninput){
                $string = CleanInput($string);
            }
             return  mb_convert_case($string, MB_CASE_LOWER, "UTF-8");
    

    }
?>