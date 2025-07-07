<?php
function GetDataArrayTableOrder($table,$orderby,$order){
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
        $SqlRequete = $db->prepare("SELECT * FROM `$table` ORDER BY $orderby $order");
        $SqlRequete->execute();
        $data_dump = array();
       while($Requete = $SqlRequete->fetch(PDO::FETCH_ASSOC)){
          $data_dump[] = $Requete;
       }   
       return $data_dump;
}
?>