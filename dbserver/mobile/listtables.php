<?php
    require_once("config/db_config.php");
    require_once("libs/dbclass.lib.php");

    echo "dbname = ". $dbname;
    $dbo = new dbclass($host, null, $user, $pass, $dbname);
    //$res = $dbo->use_db($dbname);
    $res = $dbo->list_tables();
    echo json_encode($res);
?>