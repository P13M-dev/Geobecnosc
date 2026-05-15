<?php

class Database {
    private static $instance = null;
    private const HOST = "db-geobecnosc";
    private const DBNAME = "geobecnosc";
    private const USER = "User";
    private const PASSWORD = "uvG!lBWUDD:AP|aW0<ylOO^:Dmyh:^oF[jbn|KWCMC7ZM\$ie87hnL7`I0VM#GWJv";
    private $db;

    private function __construct() {
        $this->db = mysqli_connect(self::HOST,self::USER,self::PASSWORD,self::DBNAME);
    }
    private function __destruct()
    {
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