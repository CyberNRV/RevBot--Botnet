<?php
    function Checker_3($table,$colonne,$colonne2,$colonne3,$find,$find2,$find3){
            global $db;
      $SqlCounter = $db -> prepare("SELECT COUNT(*) FROM `$table` WHERE `$colonne` = :find AND `$colonne2` = :find2 AND `$colonne3` = :find3");
      $SqlCounter -> execute(array(':find' => $find, ':find2' => $find2, ':find3' => $find3));
      $COUNT = $SqlCounter -> fetchColumn(0);
      if ($COUNT == 0){
        return FALSE;
      }else{
        return TRUE;
      }
    }
    function Checker3($table,$colonne,$colonne2,$colonne3,$find,$find2,$find3){
            global $db;
      $SqlCounter = $db -> prepare("SELECT COUNT(*) FROM `$table` WHERE `$colonne` = :find AND `$colonne2` = :find2 AND `$colonne3` = :find3");
      $SqlCounter -> execute(array(':find' => $find, ':find2' => $find2, ':find3' => $find3));
      $COUNT = $SqlCounter -> fetchColumn(0);
      if ($COUNT == 0){
        return FALSE;
      }else{
        return TRUE;
      }
    }
?>