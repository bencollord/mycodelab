<?php

namespace MyCodeLab\Database;

/**
 * Represents a SQL query that returns a result.
 */
class Select extends Query
{
  protected $table;

  protected $fields;

  /**
   * @var bool  Whether to only get distinct records.
   */
  protected $distinct = false;

  /**
   * @var array  List of parameters to be bound in a prepared statement. 
   */
  protected $parameters = array();
  
  protected $conditions;

  protected $orderBy;
  
  protected $limit;

  public function __construct(array $columns, Connection $connection) 
  {
    parent::__construct($connection);
    
    $this->fields = $columns;
  }

  public function distinct(array $columns)
  {
    $this->distinct = true;
    
    return $this;
  }

  public function from($table)
  {
    $this->table = $table;

    return $this;
  }

  /**
   * Sets the first condition in the WHERE clause.
   * 
   * This method will reset any existing WHERE conditions. To add a condition
   * to the existing clause, use andWhere or orWhere
   * 
   * @param  string $field    The column to be checked.
   * @param  string $operator The logical operator.
   * @param  mixed  $value    The variable that will be checked against.
   *                          
   * @return $this
   */
  public function where($field, $operator, $value)
  {
    $this->conditions = array();
    $validOperators   = ['=', '!=', '>', '<', '<=', '>=', 'between', 'like', 'in'];

    if (!in_array($operator, $validOperators)) {
      throw new InvalidArgumentException("$operator is not a valid SQL operator.");
    }

    // Setup condition with placeholder for prepared statement
    $this->conditions[]       = "$field $operator :$field";
    $this->parameters[$field] = $value;

    return $this;
  }
  
  public function andWhere($field, $operator, $value) 
  {
    
  }
  
  public function orWhere($field, $operator, $value) 
  {
    
  }

  public function orderBy($column, $direction = 'ASC')
  {
    // Automatically selects ASC if value is not DESC
    $direction = (strtoupper($direction) == 'DESC') ? 'DESC' : 'ASC';

    $this->orderBy[$column] = $direction;

    return $this;
  }
  
  public function limit($number)
  {
    if (!is_int($number)) {
      throw new InvalidArgumentException("'Limit' parameter must be a number.");
    }
    
    $this->limit = $number;
    
    return $this;
  }
  
  public function compile()
  {
    $columns = implode(', ', $this->fields);
    
    $this->sql = "SELECT $columns FROM $this->table";
    
    if (isset($this->conditions)) {
      $whereClause = $this->where->compile();
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