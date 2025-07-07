<?php
    function CountryCheck($arg = "",$data = ""){
        if(empty($arg) OR empty($data)){
            return false;
        }else{
            //Check Data
                $allwoeddata = array();
                $allwoeddata[] = "name";
                $allwoeddata[] = "alpha-2";
                $allwoeddata[] = "alpha-3";
                $allwoeddata[] = "country-code";
                $allwoeddata[] = "iso_3166-2";
                $allwoeddata[] = "region";
                $allwoeddata[] = "sub-region";
                $allwoeddata[] = "intermediate-region";
                $allwoeddata[] = "region-code";
                $allwoeddata[] = "sub-region-code";
                $allwoeddata[] = "intermediate-region-code";
                $igniore = true;
                foreach($allwoeddata as $tempdata){
                  if ($tempdata == $data){
                      
                      $igniore = false;
                  }
                }
                if($igniore){
                    return false;
                }
             
            //Check Country
                foreach(CountryList() as $tempdata2){
                    if($tempdata2[$data] == $arg){
                        return true;
                    }
                }
            
        }
        return false;
    }
?>