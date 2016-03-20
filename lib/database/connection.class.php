<?php

namespace Lib\Database;

use Lib\Core\Object;

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
    } 
    catch (PDOException $e) 
    {
      echo 'Whoops! An error occured!' . $e->getMessage();
    }
    return new self($pdo, $fetchMode);
  }
  
  public function select($table, $fields = array(), $where = '', $orderBy = '')
  {
    $columns    = (!empty($fields))  ? implode(', ', $fields)  : '*';
    $condition  = (!empty($where))   ? implode(', ', $where)   : '';
    $order      = (!empty($orderBy)) ? implode(', ', $orderBy) : '';
    
    $query = "SELECT $columns FROM $table";
    
    if (!empty($condition)) {
      $query .= " WHERE $condition";
    }
    if (!empty($order)) {
      $query .= " ORDERBY $order";
    }
    
    $stmt = $this->pdo->query($query);
  }
  
  public function insert($table, array $data)
  {
    $command = new SqlInsertCommand()
    
  }
    
  public function update($table, array $data, $conditions)
  {
    
  }
    
  public function delete($table, $conditions)
  {
    
  }
  
}