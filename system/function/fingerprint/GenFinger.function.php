<?php
function GenFinger() {
    // Récupérer l'adresse IP du visiteur
    $ip = $_SERVER['REMOTE_ADDR'];

    // Générer un identifiant unique en combinant l'adresse IP avec un timestamp
    $identifiant = md5($ip . date("d/m/Y"));

    return $identifiant;
}

?>