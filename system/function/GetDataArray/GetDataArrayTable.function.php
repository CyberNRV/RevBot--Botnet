<?php
function GetDataArrayTable($table){
    //Required
        global $db;
    //Request
        $SqlRequete = $db->prepare("SELECT * FROM `$table`");
        $SqlRequete->execute();
        $x = array();
       while( $Requete = $SqlRequete->fetch(PDO::FETCH_ASSOC)){
           $x[] = $Requete;
       }   
       return $x;
}
?>