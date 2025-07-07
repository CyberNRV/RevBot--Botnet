<?php
function IsValidJson($chaine) {
    if(empty($chaine)) return false;
    json_decode($chaine);
    return (json_last_error() == JSON_ERROR_NONE);
}
?>  