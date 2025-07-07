
<?php
function DateIsHourly($dateTime) {
    // Expression régulière pour le format spécifique "AAAA-MM-JJTHH:MM"
    $pattern = '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/';
    
    // Vérifie si la date correspond au format spécifié
    return preg_match($pattern, $dateTime);
}
?>