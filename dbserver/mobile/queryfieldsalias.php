<?php
    require_once("config/db_config.php");
    require_once("libs/dbclass.lib.php");

    $dbo = new dbclass($host, null, $user, $pass, $dbname);
    $sql = "SELECT field, description FROM fields_alias WHERE `table` LIKE '".$tablename."'";
    $res = $dbo->query_data($sql);
    echo json_encode($res);
?>


