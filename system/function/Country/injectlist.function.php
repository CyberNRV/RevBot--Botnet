<?php
    function InjectCountryDesign($design = "",bool $echo = true,$excludearray = array()){
        if(empty($design)){
            return false;
        }
        $final = "";
       foreach (CountryList() as $x) {
           $ign = false;
           foreach ($excludearray as $exclude){
               if ($x['country-code'] == $exclude){
                   $ign = true;
               }
           }
         
         if(!$ign){
              $Dengine = $design;
               $Dengine = str_replace("{name}",$x['name'],$Dengine);
               $Dengine = str_replace("{alpha-2}",$x['alpha-2'],$Dengine);
               $Dengine = str_replace("{alpha-3}",$x['alpha-3'],$Dengine);
               $Dengine = str_replace("{country-code}",$x['country-code'],$Dengine);
               $Dengine = str_replace("{iso_3166-2}",$x['iso_3166-2'],$Dengine);
               $Dengine = str_replace("{region}",$x['region'],$Dengine);
               $Dengine = str_replace("{sub-region}",$x['sub-region'],$Dengine);
               $Dengine = str_replace("{intermediate-region}",$x['intermediate-region'],$Dengine);
               $Dengine = str_replace("{region-code}",$x['region-code'],$Dengine);
               $Dengine = str_replace("{sub-region-code}",$x['sub-region-code'],$Dengine);
               $Dengine = str_replace("{intermediate-region-code}",$x['intermediate-region-code'],$Dengine);

            $final = $final.$Dengine;
         }
         
       }
       if($echo){
           echo $final;
       }
       return $final;

    }

?>