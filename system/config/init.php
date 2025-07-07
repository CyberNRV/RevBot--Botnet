<?php
require "./system/config/path.php";
Require $lz_path['config']."/db.php";
unset($x);
foreach (glob($lz_path['function']."/*/*.function.php") as $x) {
    require_once $x;
    $lz_debug[] = "FUNCTION: LOADED $x";
}

unset($x);
$lz_debug[] = "";

foreach (glob($lz_path['lib']."/*.lib.php") as $x) {
    require_once $x;
    $lz_debug[] = "LIB: LOADED $x";
}

$tpl = new tpl();
$msg = new msgbox();
$user = new user();
$group = new group();
$tasks = new tasks();
$bots = new bots();
$api = new api();
?>