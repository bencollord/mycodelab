<?php

namespace Lib\Database;

use \PDO;
use \PDOStatement;
use Lib\System\Object;

/**
 * Represents a database connection.
 */
class Connection extends Object
{
  /**
   * @var PDO - The raw connection
   */
  protected $pdo;
  
  /**
   * @var int - The PDO fetch mode to be used when fetching results.
   *            Defaults to PDO::FETCH_ASSOC
   */
  protected $fetchMode;
  
  protected function __construct(PDO $pdo, $fetchMode)
  {
    $this->pdo       = $pdo;
    $this->fetchMode = $fetchMode;
  }
  
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
    
    try 
    {
      $pdo = new PDO("$driver:host=$host;dbname=$dbName", $username, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $fetchMode);
    } 
    catch (PDOException $e) 
    {
      echo 'Whoops! An error occured!' . $e->getMessage();
    }
    return new self($pdo, $fetchMode);
  }
  
  /**
   * Prepares a SqlCommand object for execution.
   * 
   * Acts as a proxy method for PDO::prepare() to provide 
   * SqlCommand class access to the PDOStatement object.
   * 
   * @param SqlCommand $command  The command to be prepared.
   * @return PDOStatement
   */
  public function prepare(SqlCommand $command)
  {
    return $this->pdo->prepare($command);
  }
  
  public function query($sql, $parameters = array())
  {
    if (!empty($parameters)) {
      $statement = $this->pdo->prepare($sql);
      
      foreach ($parameters as $key => $value) {
        $statement->bindValue(":$key", $value);
      }
    } else {
      $statement = $this->pdo->query($sql);
    }
    
    return $statement->fetchAll($this->fetchMode);
  }
  
}