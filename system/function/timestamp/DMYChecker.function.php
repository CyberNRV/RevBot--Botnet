<?php
function DMYChecker($date) {
    // Créer un objet DateTime à partir de la chaîne de date et du format spécifié
    $dateTime = DateTime::createFromFormat('d/m/Y', $date);

    // Vérifier si l'objet DateTime a été créé avec succès et si la date correspond au format
    return $dateTime && $dateTime->format('d/m/Y') === $date;
}
?>