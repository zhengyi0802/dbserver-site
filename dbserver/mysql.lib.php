<?php

    class mysqlobj {
      private $host = "";
      private $user = "";
      private $pass = "";
      private $database = "";
      private $link;
      private $last_sql = "";
      private $last_id = 0;
      private $last_num_rows = 0;
      private $error_message = "";

      public function __construct($host, $user, $pass) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;

        $this->link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($this->host, $this->user, $this->pass));

        if (mysqli_connect_error()) {
            $this->error_message = "Failed to connect to MySQL: " . mysqli_connect_error();
            echo $this->error_message;
            return false;
        }

      } // end of __construct

      public function __destruct() {
        mysqli_close($this->link);
      } // end of __destruct

      public function use_database($dbname) {
        $this->database = $dbname;
        if (!(bool)mysqli_query($this->link, "USE ".$this->mysql_database))
            $this->error_message = 'Database '.$this->mysql_database.' does not exist!';
      } // end of use_database

      public function create_database($dbname) {
        $this->database = $dbname;
        if (!(bool)mysqli_query($this->link, "CREATE DATABASE ".$this->database))
            $this->error_message = 'Database '.$this->database.' can not be created!';
      } // end of create_database

      public function drop_database() {
        if (!(bool)mysqli_query($this->link, "DROP DATABASE ".$this->database))
            $this->error_message = 'Database '.$this->database.' can not be deleted!';
      } // end of drop_database

      public function list_databases() {
        $result = mysqli_query($this->link, "SHOW DATABASES");
        $res = array();
        while( $row = mysqli_fetch_row($result)) {
          array_push($res, $row[0]);
        }
        return $res;
      }

      public function create_table($tablename, $json) {
      } // end of create_table

      public function modify_table($tablename, $sql) {
      } // end of modify_table

      public function delete_table($tablename, $flag=false) {
        if ($flag == true) {
            if (!(bool)mysqli_query($this->link, "DROP TABLE '".$this->database."'"))
                $this->error_message = 'Table '.$tablename.' can not be deleted!';
        }
        return;
      } // end of delete_table

      public function list_tables() {
        $result = mysqli_query($this->link, "SHOW TABLES FROM " . $this->database);
        $res = array();
        while( $row = mysqli_fetch_row($result)) {
          array_push($res, $row[0]);
        }
        return $res;
      } // end of list_tables

      public function list_table_structure($tablename) {
      } // end of list_table_structure

      public function insert_data($tablename, $json) {
      } // end of insert_data

      public function modify_data($tablename, $json, $condition) {
      } // end of modify_data

      public function delete_data($tablename, $condition, $flag=false) {
      } // end of delete_data

      public function query_data($tablename, $condition) {
      } // end of query_data($tablename, $condition)
/*
      public function query_data($sqlstring) {
      } // end of query_data($sqlstring)
*/
      public function execute_command($sqlstring) {
      } // end of execute_command

    } // end of class
