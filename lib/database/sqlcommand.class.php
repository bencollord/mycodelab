<?php

namespace Lib\Database;

use Lib\System\Object;

/**
 * Represents a SQL command that affects database data.
 */
class SqlCommand extends Object
{
  /**
   * Command type constants
   */
  const CMD_TYPE_RAW      = 0;
  const CMD_TYPE_PREPARED = 1;
  const CMD_TYPE_PROC     = 2;
  
  /**
   * @var Connection  Link to database
   */
  protected $connection;
  
  /**
   * @var int  Command type set from constants
   */
  protected $type;

  /**
   * @var string  The raw SQL to be executed on the database
   */
  protected $sql;

  /**
   * @var array  List of parameters to be bound in a prepared statement. 
   */
  protected $parameters = array();

  public function __construct(Connection $conn = null)
  {
    $this->connection = $conn ?? Connection::forge();
  }

  public function write($cmdText, array $params = array())
  {
    $this->sql        = $cmdText;
    $this->type       = (empty($params)) ? static::CMD_TYPE_RAW : static::CMD_TYPE_PREPARED;
    $this->parameters = $params;
    
    return $this;
  }
  
  public function append($cmdText, array $params = array())
  {
    $this->sql .= ' ' . $cmdText;
    $this->parameters = array_merge($this->parameters, $params);
    
    if (!empty($params) && $this->type == static::CMD_TYPE_RAW) {
      $this->type = static::CMD_TYPE_PREPARED;
    }
    
    return $this;
  }
  
  protected function bind()
  {
    $statement = $this->connection->prepare($this);
    
    foreach ($this->parameters as $key => $value) {
      $statement->bindParam(":$key", $value);
    }
   
    return $statement;
  }

  public function execute()
  {
    $statement = $this->bind();
    $statement->execute();
    
    return $statement->rowCount();
  }
  
  public function executeQuery()
  {
    $statement = $this->bind();
    $statement->execute();
    
    return $statement->fetchAll();
  }
  

  public function __toString()
  {
    return $this->sql;
  }

}