<?php
    require_once("config/db_config.php");
    require_once("libs/dbclass.lib.php");

    $dbo = new dbclass($host, null, $user, $pass, $dbname);
    if ($tablename == 'city') {
       $sql  = "SELECT city.id AS id, city.name AS city, state.name AS state, country.name AS country FROM city ";
       $sql .= "LEFT JOIN country ON city.country_id = country.id ";
       $sql .= "LEFT JOIN state ON city.state_id = state.id WHERE 1";
    } else if ($tablename == 'state') {
       $sql  = "SELECT state.id AS id, country.name AS country, state.name AS state FROM state ";
       $sql .= "LEFT JOIN country ON state.country_id = country.id WHERE 1";
    } else if ($tablename == 'district') {
       $sql  = "SELECT district.id AS id, country.name AS country, city.name AS city, district.name AS district FROM district ";
       $sql .= "LEFT JOIN country ON district.country_id = country.id ";
       $sql .= "LEFT JOIN city ON district.city_id = city.id WHERE 1";
    } else {
       $sql = "SELECT * FROM `".$tablename."` WHERE 1";
    }
    $res = $dbo->query_data($sql);
    echo json_encode($res);
?>


