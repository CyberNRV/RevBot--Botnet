<?php
function GetDataArrayTableOrderWhere1arg($table,$orderby,$order,$where,$wherearg){
    //Check Order
        if(empty($order)){
            $order = "DESC";
        }else{
            if(!$order == 'ASC' OR !$order == "DESC"){
                $order = "DESC";
            }
        }
    //Protect OrderBy
        $orderby = CleanInput($orderby);
    //Required
        global $db;
    //Request
        $SqlRequete = $db->prepare("SELECT * FROM `$table` WHERE $where = :wherearg ORDER BY $orderby $order");
        $SqlRequete->execute(array(":wherearg" => $wherearg));
        $data_dump = array();
       while($Requete = $SqlRequete->fetch(PDO::FETCH_ASSOC)){
          $data_dump[] = $Requete;
       }   
       return $data_dump;
}
?>