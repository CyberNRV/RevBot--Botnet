<?php
    function Debug($data){
        if(!is_array($data)){
            echo "<p><b>CYBERNRV Debug :</b> ".$data."</p><br/>";
        }else{
            foreach($data as $debug){
                echo "<p><b>CYBERNRV Debug :</b> ".$debug."</p><br/>";
            }
        }
        return true;
    }
?>