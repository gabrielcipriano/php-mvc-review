<?php
namespace App\Models;
use PDO;
use PDOException;

/**
 * Post model
 * 
 * PHP version 7
 */

 class Post extends \Core\Model{
     /**
      * Get all posts as an associative array
      * @return array
      */
      public static function getAll(){
          try{
            $db = static::getDB();

            $stmt = $db->query('SELECT id, title, content FROM posts
            ORDER BY created_at');
    
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
          }catch(PDOException $e){
            echo $e->getMessage();
          }
    }
 }

?>