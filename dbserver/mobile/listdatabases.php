<?php
    require_once("config/db_config.php");
    require_once("libs/dbclass.lib.php");

    $dbo = new dbclass($host, null, $user, $pass, null);
    $res = $dbo->list_databases();
    echo json_encode($res);
?>
