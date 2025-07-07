<?php
function IntToCent($montant) {
    // Remplacer les virgules par des points
    $montant = str_replace(',', '.', $montant);
    
    // Supprimer les éventuels espaces pour assurer le bon format
    $montant = str_replace(' ', '', $montant);
    
    // Convertir en centimes en multipliant par 100
    $centimes = $montant * 100;
    
    return $centimes;
}
