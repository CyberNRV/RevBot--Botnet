<?php
	function SqlUpdater1($table,$column,$set,$where,$arg){
    global $db;
    $SQL = $db->prepare("UPDATE `$table` SET `$column` = :column WHERE `$where` = :arg");
    $SQL->execute(array(":column" => $set, ":arg" => $arg));
    return true;
	}
?>