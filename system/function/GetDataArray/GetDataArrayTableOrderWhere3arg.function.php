<?php
function GetDataArrayTableOrderWhere3arg($table, $orderby, $order, $where, $wherearg, $where2, $wherearg2, $where3, $wherearg3){
    // Vérification de l'ordre
    $order = (empty($order) || !in_array(strtoupper($order), ['ASC', 'DESC'])) ? "DESC" : strtoupper($order);

    // Nettoyage de l'attribut de tri
    $orderby = CleanInput($orderby);

    // Connexion à la base de données
    global $db;

    // Requête SQL
    $SqlRequete = $db->prepare("SELECT * FROM `$table` WHERE $where = :wherearg AND $where2 = :wherearg2 AND $where3 = :wherearg3 ORDER BY $orderby $order");
    $SqlRequete->execute(array(":wherearg" => $wherearg, ":wherearg2" => $wherearg2, ":wherearg3" => $wherearg3));

    // Récupération des données
    $data_dump = $SqlRequete->fetchAll(PDO::FETCH_ASSOC);

    return $data_dump;
}
?>