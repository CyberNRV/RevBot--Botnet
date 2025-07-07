<?php
    function CounterKeywords($keywords){
        if(empty($keywords)){ return "0";}
        $keywords_array = array();
        $keywords_array = explode(",",$keywords);
        if(!is_array($keywords_array)){
            return "0";
        }
        return count($keywords_array);
    }
?>