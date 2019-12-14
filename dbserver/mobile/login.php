<?php
    require_once("config/db_config.php");
    require_once("libs/dbclass.lib.php");

    $dbo = new dbclass($host, null, $user, $pass, $dbname);
    $sql  = "SELECT * FROM users ";
    $sql .= "WHERE `account` LIKE '".$username."' ";
    $sql .= "AND `password` LIKE '".$password."'";
    $res = $dbo->query_data($sql);
    //echo $sql."<br>";
    //echo count($res)."<br>";
    if (count($res) > 0) {
       echo "correct";
    } else {
       echo "failure";
    }

?>



