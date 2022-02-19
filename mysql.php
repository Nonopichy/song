<?php
Class MySQL{
    public static $host = "127.0.0.1";
    public static $user = "root";
    public static $password = 'Strength';
    public $dbName;
    public $conn;
 
    function __construct($dbName) {
        $this->dbName = $dbName;
    }
    public function openConnection(){
        return $this->conn = mysqli_connect(MySQL::$host, MySQL::$user, MySQL::$password, $this->dbName);
    }
    public function getContains($select, $table, $targert_v, $contains){
        $list = array();
        $search = $this->conn->query("SELECT ".$select." FROM ".$table."");
        $contains = strtolower($contains);
         foreach ($search as $key){
            $title = strtolower($key[$targert_v]);
            if(strpos($title, $contains) !== false){
                array_push($list,$key);
            }
        }
        return $list;
    }
}
?>