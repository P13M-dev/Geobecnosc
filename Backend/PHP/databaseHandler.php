<?php

class Database {
    private static $instance = null;
    private const HOST = "db-geobecnosc";
    private const DBNAME = "geobecnosc";
    private const USER = "User";
    private const PASSWORD = "aMgtm48OBi0cxEvG5I8MQBj4oOsG2asakcEpymZySn3i8SyNSzDzOjWIkUfqxwMp";
    private $db;

    private function __construct() {
        $this->db = mysqli_connect(self::HOST,self::USER,self::PASSWORD,self::DBNAME);
    }

    public function __destruct(){
        mysqli_close($this->db);
    }

    public static function get() {
        if (self::$instance === null) self::$instance = new self();
        return self::$instance;
    }
    public function query($sql, $params = []) {
        $result = $this->db->execute_query($sql, $params);
        if ($result instanceof mysqli_result) return $result->fetch_all(MYSQLI_ASSOC);
        else return $result; 
    }
}

?>