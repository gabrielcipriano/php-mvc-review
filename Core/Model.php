<?php      
namespace Core;
use PDO;
use PDOException;

/**
 * Base model
 * 
 * PHP version 7
 */
abstract class Model{
    /**
     * Get the PDO database connection
     * @return mixed
     * */
    protected static function getDB(){
        static $db = null;
        if ($db == null) {
            $host = "localhost";
            $dbname = "mvcreview";
            $username = "root";
            $password = "secret";
            try {
                $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
                            $username, $password);
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        return $db;
    }
}

?>