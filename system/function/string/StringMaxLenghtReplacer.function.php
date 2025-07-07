<?php
function StringMaxLenghtReplacer($string = "", $nb_caracs = "", $separator = ""){
    $string = strip_tags(html_entity_decode($string));
    if( strlen($string) <= $nb_caracs ){
        $final_string = $string;
    } else {
        $final_string = "";
        $words = explode(" ", $string);
        foreach( $words as $value ){
            if( strlen($final_string . " " . $value) < $nb_caracs ){
                if( !empty($final_string) ) $final_string .= " ";
                $final_string .= $value;
            } else {
                break;
            }
        }
        $final_string .= $separator;
    }
    return $final_string;
}
?>