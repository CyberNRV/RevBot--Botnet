<?php
    function GetDataArrayTableOrderLimit($table,$orderby,$order,$limit){
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
        //Protect Limit
            $limit = CleanInput($limit);
        //Required
            global $db;
        //Request
            $SqlRequete = $db->prepare("SELECT * FROM `$table` ORDER BY $orderby $order LIMIT $limit");
            $SqlRequete->execute();
            $data_dump = array();
           while($Requete = $SqlRequete->fetch(PDO::FETCH_ASSOC)){
              $data_dump[] = $Requete;
           }   
           return $data_dump;
    }
?>