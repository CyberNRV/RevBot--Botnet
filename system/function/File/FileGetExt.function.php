<?php
    function FileInfoGetExt($xfile,$filterlist = array()){
        $type_file = $xfile['type'];
        $x = false;
        foreach ($filterlist as $allowtypefile) {
            if (strstr($type_file, $allowtypefile)){
                if (!$x){
                   return $allowtypefile;
                }
               $x = true;
            }
        }
        return false;
    }


?>