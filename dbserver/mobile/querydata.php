<?php
    require_once("config/db_config.php");
    require_once("libs/dbclass.lib.php");

    $dbo = new dbclass($host, null, $user, $pass, $dbname);
    if ($tablename == 'city') {
       $sql  = "SELECT city.id AS id, city.name AS city, state.name AS state, country.name AS country FROM city ";
       $sql .= "LEFT JOIN country ON city.country_id = country.id ";
       $sql .= "LEFT JOIN state ON city.state_id = state.id ";
       $sql .= " WHERE 1";
    } else if ($tablename == 'state') {
       $sql  = "SELECT state.id AS id, country.name AS country, state.name AS state FROM state ";
       $sql .= "LEFT JOIN country ON state.country_id = country.id ";
       $sql .= "WHERE 1";
    } else if ($tablename == 'district') {
       $sql  = "SELECT district.id AS id, country.name AS country, city.name AS city, district.name AS district FROM district ";
       $sql .= "LEFT JOIN country ON district.country_id = country.id ";
       $sql .= "LEFT JOIN city ON district.city_id = city.id ";
       $sql .= "WHERE 1";
    } else if ($tablename == 'reseller') {
       $sql  = "SELECT reseller.id AS id, reseller.reseller_id AS reseller_id, country.name AS country, state.name AS state, ";
       $sql .= "city.name AS city, district.name AS district, reseller.telephone AS telephone, ";
       $sql .= "reseller.company_phone AS company_phone FROM reseller ";
       $sql .= "LEFT JOIN country ON reseller.country_id = country.id ";
       $sql .= "LEFT JOIN state ON reseller.state_id = state.id ";
       $sql .= "LEFT JOIN city ON reseller.city_id = city.id ";
       $sql .= "LEFT JOIN district ON reseller.district_id = district.id ";
       $sql .= "WHERE 1";
    } else if ($tablename == 'vendor' ) {
       $sql  = "SELECT vendor.id AS id, vendor.name AS vendor, vendor.contact AS contact, country.name AS country, ";
       $sql .= "state.name AS state, city.name AS city, district.name AS district, vendor.postcode AS postcode, ";
       $sql .= "vendor.address AS address, vendor.telephone AS telephone FROM vendor ";
       $sql .= "LEFT JOIN country ON country.id = vendor.country_id ";
       $sql .= "LEFT JOIN state ON state.id = vendor.state_id ";
       $sql .= "LEFT JOIN city ON city.id = vendor.city_id ";
       $sql .= "LEFT JOIN district ON district.id = vendor.district_id ";
       $sql .= "WHERE 1";
    } else if ($tablename == "product") {
       $sql  = "SELECT product.id AS id, vendor.name AS vendor, catagory.name AS catagory, product.type_id AS type, ";
       $sql .= "product.name AS product, product.description AS description, product.photo AS photo, product. ";
       $sql .= "product.create_date AS create_date, users.username AS create_user, product.has_barcode AS has_barcode ";
       $sql .= "FROM product ";
       $sql .= "LEFT JOIN vendor ON product.vendor_id = vendor.id ";
       $sql .= "LEFT JOIN catagory ON product.catagory_id = catagory.id ";
       $sql .= "LEFT JOIN users ON product.create_user_id = users.id ";
       $sql .= "WHERE 1 ";
    } else if ($tablename == "stock_in") {
       $sql  = "SELECT stock_in.id AS id, product.name AS product, stock_in.barcode AS barcode, ";
       $sql .= "stock_in.ethernet_mac AS ethernet_mac, stock_in.wifi_mac AS wifi_mac, stock_in.create_date AS create_date, ";
       $sql .= "users.username AS create_user, stock_in.in_type AS stock_type FROM stock_in";
       $sql .= "LEFT JOIN product ON stock_in.product_id = product.id ";
       $sql .= "LEFT JOIN users ON stock_in.create_user_id = users.id ";
       $sql .= "WHERE 1";
    } else if ($tablename == "stock_out") {
       $sql  = "SELECT stock_out.id AS id, stock_out.barcode AS barcode, stock_out.create_date AS create_date, ";
       $sql .= "users.username AS create_user, stock_out.out_type AS out_type FROM stock_out ";
       $sql .= "LEFT JOIN users ON stock_out.create_user_id = users.id ";
       $sql .= "WHERE 1";
    } else {
       $sql  = "SELECT * FROM `".$tablename."` ";
       $sql .= "WHERE 1";
    }
    $res = $dbo->query_data($sql);
    echo json_encode($res);
?>



