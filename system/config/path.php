<?php
    $lz_path = array();
    $lz_path["root"]                    = "./";
    $lz_path["system"]                  =   $lz_path["root"]."system";
    $lz_path["function"]                  =   $lz_path["system"]."/function";
    $lz_path["lib"]                  =   $lz_path["system"]."/lib";
    $lz_path["config"]                  =   $lz_path["system"]."/config";

    $lz_path["db"]                      =   $lz_path["config"]."/db.php";
    $lz_path["init"]                    =   $lz_path["config"]."/init.php";
    $lz_path["pages"]                    =   $lz_path["system"]."/pages";
    $lz_path["imports"]                    =   $lz_path["system"]."/imports";

    $lz_debug[] = "PATH: LOADED";
?>