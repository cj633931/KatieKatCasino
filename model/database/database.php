<?php

class Database {

    private static $dsn = 'mysql:host=localhost;dbname=program3cj633931';
    private static $dbusername = 'root';
    private static $password = '';
    private static $db;

    private function __construct() {
        
    }

    public static function getDB() {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn, 
                                    self::$dbusername, 
                                    self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                //alert($error_message);
            }
        }
        return self::$db;
    }

}

?>
