<?php
	function SqlUpdater2($table,$column,$set,$column2,$set2,$where,$arg){
        global $db;
        $SQL = $db->prepare("UPDATE `$table` SET `$column` = :column , `$column2` = :column2  WHERE `$where` = :arg");
        $SQL->execute(array(":column" => $set, ":arg" => $arg,":column2" => $set2, ":arg" => $arg));
        return true;
	}
?>