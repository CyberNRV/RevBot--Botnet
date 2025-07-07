<?php
    function SqlUpdater1Where2args($table = "",$column = "",$set = "",$where = "",$arg = "",$where2 = "",$arg2 = ""){
        global $db;
        $SQL = $db->prepare("UPDATE `$table` SET `$column` = :column WHERE `$where` = :arg AND `$where2` = :arg2");
        $SQL->execute(array(":column" => $set, ":arg" => $arg, ":arg2" => $arg2));
        return true;
        }
?>