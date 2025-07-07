<?php
  $DB_HOST     =	'localhost';
  $DB_NAME     =	'revbot';
  $DB_USERNAME =	'root';
  $DB_PASSWORD =	'';
//Connexion a la Base de donnés (UTF8 General-CI)
  if (empty($db)){
          $db = new PDO(
              'mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8',
              ''.$DB_USERNAME.'',
               ''.$DB_PASSWORD.'',
              array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
          );
  } 
  $lz_debug[] = "DB: LOADED";
?>