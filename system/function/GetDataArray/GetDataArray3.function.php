<?php
function GetDataArray3($table, $colonne1, $colonne2,$colonne3, $byselect1, $byselect2, $byselect3){
    global $db;
    $SqlRequete = $db->prepare("SELECT * FROM `$table` WHERE `$colonne1` = :byselect1 AND `$colonne2` = :byselect2  AND `$colonne3` = :byselect3  LIMIT 1");
    $SqlRequete->execute(array(':byselect1' => $byselect1, ':byselect2' => $byselect2, ':byselect3' => $byselect3));
    $Requete = $SqlRequete->fetch(PDO::FETCH_ASSOC);
    if (empty($Requete)){
        return false;
    }else{
        return $Requete;
    }
}
?>