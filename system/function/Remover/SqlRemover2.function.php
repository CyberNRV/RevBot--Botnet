<?php
    function SQLRemover2($table, $column, $arg, $column2, $arg2) {
        $table = htmlspecialchars(CleanInput($table));
        $column = htmlspecialchars(CleanInput($column));
        global $db;
        //Sql Interact
        $SQL = $db->prepare("DELETE FROM $table WHERE $column = :arg AND $column2 = :arg2");
        $SQL->execute(array(':arg' => $arg, ':arg2' => $arg2));
        if (!Checker1($table, $column,$arg)) {
            return TRUE;
        } else {
            return FALSE;
        }
        return FALSE;
    }
?>