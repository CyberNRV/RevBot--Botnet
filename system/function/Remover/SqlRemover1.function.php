<?php
function SQLRemover1($table, $column, $arg) {
    $table = htmlspecialchars(CleanInput($table));
    $column = htmlspecialchars(CleanInput($column));
    global $db;
    //Sql Interact
    $SQL = $db->prepare("DELETE FROM $table WHERE $column = :arg");
    $SQL->execute(array(':arg' => $arg));
    if (!Checker1($table, $column,$arg)) {
        return TRUE;
    } else {
        return FALSE;
    }
    return FALSE;
}
?>