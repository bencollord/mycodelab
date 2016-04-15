<?php

namespace Library\Database;

use \PDO;
use \PDOException;
use Library\System\Object;

/**
 * Represents a database connection.
 * 
 * Wraps PDO with a streamlined interface.
 */
class Connection extends PDO
{   
  /**
   * Get database connection based on config constants
   * 
   * @return self
   */
  public static function forge($fetchMode = PDO::FETCH_ASSOC) 
  {
    $driver   = DB_DRIVER;
    $host     = DB_HOST;
    $dbName   = DB_NAME;
    $username = DB_USERNAME;
    $password = DB_PASSWORD;
    
    try {
      $instance = new static("$driver:host=$host;dbname=$dbName", $username, $password);
      
      $instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $fetchMode);
    } catch (PDOException $e) {
      throw new Exception('Error connecting to database ' . $e->getMessage());
    }
    
    return $instance;
  }
  
  /**
   * Returns an SQLCommand object.
   */
  public function query($sql, $params = array())
  {
    if (empty($params)) {
      $statement = parent::query($sql);
    } else {
      $statement = $this->prepare($sql);
      
      foreach ($params as $key => $value) {
        $statement->bindValue(":$key", $value);
      }
      
      $statement->execute();
    }
    
    return $statement->fetchAll();
  }
  
}