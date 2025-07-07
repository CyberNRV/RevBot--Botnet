<?php
function GetDataArrayTableWhere2arg($table,$where,$wherearg,$where2,$wherearg2){
    //Required
        global $db;
    //Request
        $SqlRequete = $db->prepare("SELECT * FROM `$table` WHERE $where = :wherearg AND $where2 = :wherearg2");
        $SqlRequete->execute(array(":wherearg" => $wherearg,":wherearg2" => $wherearg2));
        $data_dump = array();
       while($Requete = $SqlRequete->fetch(PDO::FETCH_ASSOC)){
          $data_dump[] = $Requete;
       }   
       return $data_dump;
}
?>