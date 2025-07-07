<?php
     function UploadFile($xfile= "",$filename ="",$location = "",$allowtypefiles = array(),$msgbox = false){
        $errors = array();
     $content_dir = $location;
     $tmp_file    = $xfile['tmp_name'];
     if (empty($location)){
        $errors[] = "msgbox_error_UploadFile_location_is_empty";
     }else{
        if (!file_exists($location)){
            mkdir($location,"0777");
         }
         chmod($location, 0777);
     }
     if (!is_uploaded_file($tmp_file)) {
                                                                                  $errors[] = "msgbox_error_UploadFile_empty";
     } else { 
         // on vérifie maintenant l'extension
             $type_file = $xfile['type'];
             foreach ($allowtypefiles as $allowtypefile) {
                 if (strstr($type_file, $allowtypefile)){
                    $type_file_final = $allowtypefile;
                    $x = true;
                 }
             }
             if (!$x){ 
                                                                                  $errors[]  = "msgbox_error_UploadFile_invalid_type_file";
             } else {
                 if (empty($type_file_final)){                                    
                                                                                  $errors[]  = "msgbox_error_UploadFile_unkown_type_file";  
                 }
                 $name_file = $xfile['name'];
                 if (!move_uploaded_file($tmp_file, $content_dir . $name_file)) { 
                                                                                   $errors[] = "msgbox_error_UploadFile_movefile_failed"; 
                 } else {
                     $file_dir = ($content_dir . $filename . '.' . $type_file_final);
                    if (file_exists($file_dir)){
                        unlink($file_dir);
                    }
                     rename($content_dir . $name_file,$file_dir);
                 }
             }
    }
    if (!empty($errors)){
        //if ($msgbox){
        //    foreach($errors as $error){
        //        MsgBoxWord($error,"MSGBOX_danger");
        //    }
        //}
        return $errors;
    }else{
        //if ($msgbox){
        //    MsgBoxWord("success_UploadFile","MSGBOX_success");
        //}
        return true;
    }
}
?>