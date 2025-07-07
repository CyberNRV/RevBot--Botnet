<?php
    function Checker1($table,$colonne,$find){
      global $db;
      $SqlCounter = $db -> prepare("SELECT COUNT(*) FROM `$table` WHERE `$colonne` = :find");
      $SqlCounter -> execute(array(':find' => $find));
      $COUNT = $SqlCounter -> fetchColumn(0);
      if ($COUNT == 0){
        return FALSE;
      }else{
        return TRUE;
      }
    }
?>