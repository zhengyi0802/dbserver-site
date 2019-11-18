<?php
    require_once("config/db_config.php");
    require_once("libs/dbclass.lib.php");

    $dbo = new dbclass($host, null, $user, $pass, $dbname);
    $res = $dbo->drop_table($tablename, false);

?>
