<?php
function RemainingDays($dateCible) {
    // Date actuelle
    $dateActuelle = new DateTime();

    // Date cible
    $dateCibleObj = DateTime::createFromFormat('d/m/Y', $dateCible);

    // Calcul du nombre de jours restants
    $interval = $dateActuelle->diff($dateCibleObj);
    $joursRestants = $interval->format('%a');

    return $joursRestants;
}
?>