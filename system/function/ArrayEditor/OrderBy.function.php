<?php
    function ArrayEditorOrderBy(array $array = array(),$orderby = "DESC",$why = "priority"){                           
      $array_raw = array();
     // foreach($finalpack as $tempx){
     //    $x = array();
     //    $x['priority'] = $tempx->GetPRIORITY();
     //    $x['token']   = $tempx->GetTOKEN();
     //    $array_raw[] = $x;
     // 
     // }
      @usort($array_raw, function($a, $b,$why) {
         if ($a[$why] == $b[$why]) {
             return @$a['sold_count'] < $b['sold_count'] ? 1 : -1;
         }
     
         return @$a[$why] < $b[$why] ? 1 : -1;
     });

   return $array_raw;
}
?>