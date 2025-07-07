<?php
    function FileCheckAllwoedExt($ext,$extarray){
        if(!is_array($extarray)){
           return false;
        }else{
            foreach ($extarray as $x){
                if($x == $ext){
                    return true;
                }
            }
            return false;
        }
    }

?>