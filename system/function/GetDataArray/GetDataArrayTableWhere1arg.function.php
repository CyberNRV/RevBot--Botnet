<?php
function GetDataArrayTableWhere1arg($table,$where,$wherearg){
    //Required
        global $db;
    //Request
        $SqlRequete = $db->prepare("SELECT * FROM `$table` WHERE $where = :wherearg");
        $SqlRequete->execute(array(":wherearg" => $wherearg));
        $data_dump = array();
       while($Requete = $SqlRequete->fetch(PDO::FETCH_ASSOC)){
          $data_dump[] = $Requete;
       }   
       return $data_dump;
}
?>