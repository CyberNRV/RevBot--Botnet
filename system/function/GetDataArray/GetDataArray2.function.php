<?php
function GetDataArray2($table, $colonne1, $colonne2, $byselect1, $byselect2){
    global $db;
    $SqlRequete = $db->prepare("SELECT * FROM `$table` WHERE `$colonne1` = :byselect1 AND `$colonne2` = :byselect2 LIMIT 1");
    $SqlRequete->execute(array(':byselect1' => $byselect1, ':byselect2' => $byselect2));
    $Requete = $SqlRequete->fetch(PDO::FETCH_ASSOC);
    if (empty($Requete)){
        return false;
    }else{
        return $Requete;
    }
}
?>