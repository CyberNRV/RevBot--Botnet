<?php
function CountryFind($countrycode = ""){
    $countrycode = CleanInput($countrycode);
    $data = CountryList();
    foreach($data as $x){
        if($x['country-code'] == $countrycode){
            return $x;
        }
    }
    return false;
}
?>