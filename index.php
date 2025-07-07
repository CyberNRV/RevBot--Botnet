<?php
    //POWER BY CYBERNRV
    session_start();
    require_once "./system/config/init.php";



    $page = $tpl->GetPage(@$_GET['p']);
    require_once $page;
?>