<?php
function GetDataArray($table, $colonne1, $byselect1){
    global $db;
    $SqlRequete = $db->prepare("SELECT * FROM `$table` WHERE `$colonne1` = :byselect1 LIMIT 1");
    $SqlRequete->execute(array(':byselect1' => $byselect1));
    $Requete = $SqlRequete->fetch(PDO::FETCH_ASSOC);
    if (empty($Requete)){
        return false;
    }else{
        return $Requete;
    }
}
?>