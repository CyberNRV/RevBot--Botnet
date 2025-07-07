<?php
function IsHourlyToTimestemp($dateTime) {
    // Convertir la date en objet DateTime
    $dateTimeObj = DateTime::createFromFormat('Y-m-d\TH:i', $dateTime);
    
    // Vérifier si la conversion a réussi
    if ($dateTimeObj !== false) {
        // Renvoyer le timestamp correspondant
        return $dateTimeObj->getTimestamp();
    } else {
        // En cas d'échec de la conversion
        return false;
    }
}
?>