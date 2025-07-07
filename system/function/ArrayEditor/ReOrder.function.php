<?php
function ReOrder(array $array_raw){
    @usort($array_raw, function($a, $b) {
       if ($a['priority'] == $b['priority']) {
           return @$a['sold_count'] < $b['sold_count'] ? 1 : -1;
       }
       return @$a['priority'] < $b['priority'] ? 1 : -1;
   });
}
?>