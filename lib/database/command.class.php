<?php

namespace Lib\Database;

use Lib\Core\Object;

/**
 * Represents a SQL query to the database
 * 
 * @todo: add support for the following features:
 *        - aggregate functions 
 *        - unions
 *        - joins
 *        - limit 
 *        - offset
 *        - stored procedures
 */
class Command extends Object
{
  /**
   * Command type constants
   */
  const TYPE_TEXT   = 0;
  const TYPE_SELECT = 1;
  const TYPE_INSERT = 2;
  const TYPE_UPDATE = 3;
  const TYPE_DELETE = 4;
  
  /**
   * @var Connection  Link to database
   */
  protected $connection;
  
  /**
   * @var string  The raw SQL to be executed on the database
   */
  protected $sql;
  
  /**
   * @var int  Command type value from list of class constants
   */
  protected $type;
  
  /**
   * @var string  The name of the table being targeted
   */
  protected $tableName;
  
  /**
   * @var string[]  List of targeted columns
   */
  protected $columns = array();
  
  /**
   * @var string
   */
  protected $whereClause = array();
  
  /**
   * @var bool  Whether to only get distinct records.
   */
  protected $distinct = false;
  
  /**
   * @var string[]  List of columns to order results by
   */
  protected $orderBy = array();
  
  /**
   * @var array  List of parameters to be bound in a prepared statement. 
   */
  protected $parameters = [
    'values'     => array(),
    'conditions' => array()
  ];
  
  public function __construct(Connection $conn)
  {
    $this->connection = $conn;
  }
  
  public function select(array $columns) 
  {
    $this->type     = static::TYPE_SELECT;
    $this->columns  = $columns;
    
    return $this;
  }
  
  public function selectDistinct(array $columns)
  {
    $this->distinct = true;
    
    return $this->select($columns);
  }
  
  public function from($table)
  {
    $this->tableName = $table;
    
    return $this;
  }
  
  public function insertInto($table) 
  {
    $this->type  = static::TYPE_INSERT;
    $this->table = $table;
    
    return $this;
  }
  
  public function update($table) 
  {
    $this->type      = static::TYPE_UPDATE;
    $this->tableName = $table;
    
    return $this;
  }
  
  public function set(array $names, array $values)
  {
    $this->columns = $names;
    $this->parameters['set'] = array_combine($names, $values);
    
    return $this;
  }
  
  public function delete(array $columns) 
  {
    $this->type    = static::TYPE_DELETE;
    $this->columns = $columns;
    
    return $this;
  }
  
  /**
   * Sets the WHERE clause of the command. Overwrites any existing value.
   * 
   * @todo: add support for appending AND and OR clauses
   * 
   * @param  string $column  
   * @param  string $operator
   * @param  mixed  $value   
   *                          
   * @return $this
   */
  public function where($column, $operator, $value)
  {
    $validOperators = ['=', '!=', '>', '<', '<=', '>=', 'between', 'like', 'in'];
    
    if (!in_array($operator, $validOperators)) {
      throw new InvalidArgumentException("$operator is not a valid SQL operator.");
    }
    
    // Setup condition with placeholder for prepared statement
    $this->whereClause         = "$column $operator :$column";
    $this->parameters[$column] = $value;
    
    return $this;
  }
  
  public function orderBy($column, $direction = 'ASC')
  {
    if ($direction != 'ASC' || $direction != 'DESC') {
      throw new InvalidArgumentException("$direction is not a valid sorting order");
    }
    
    $this->orderBy[] = $column . ' ' . ucwords($direction);
    
    return $this;
  }
  
  public function compile()
  {
    $columns  = implode(', ', $this->columns);
    $tokens   = array_keys($this->parameters);
    $bindings = array();
    
    foreach ($tokens as $token) {
      $bindings[] = "$token=:$token";
    }
    
    $placeholders = implode(', ', $bindings);
    
    switch ($this->type) {
      case static::TYPE_SELECT:
        $this->sql = "SELECT $columns FROM $this->tableName WHERE $this->whereClause ORDER BY $this->orderBy";
        break;
      case static::TYPE_INSERT:
        $this->sql = "INSERT INTO $this->tableName ($columns) VALUES ($placeholders)";
        break;
      case static::TYPE_UPDATE:
        $this->sql = "UPDATE $table SET $placeholders WHERE $this->whereClause";
      case static::TYPE_DELETE: 
        $this->sql = "DELETE FROM $table WHERE $this->whereClause";
    }
    
    return $this;
  }
  
  public function execute()
  {
    return $this;
  }
  
  public function __toString()
  {
    return $this->sql;
  }
  
}