<?php

namespace Library\Database;

use \PDO;
use \PDOStatement;
use \PDOException;
use \ArrayAccess;
use \IteratorAggregate;
use Library\System\Object;

/**
 * Represents the result of an SQL query.
 * 
 * Experimental class that wraps data from \PDOStatement in a static interface 
 * so that it can be mocked for tests or later used to define a more general
 * interface for result sets in the framework.
 */
class SqlResult extends Object implements ArrayAccess, IteratorAggregate
{
  protected $rows;
  protected $errorCode;
  protected $errorInfo;
  protected $columnCount;
  protected $affectedRows;

  public function __construct(PDOStatement $statement)
  {
    // @todo: Find cleaner way to deal with this. 
    try {
      $this->rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      $this->rows = null;
    }

    $this->errorCode    = $statement->errorCode();
    $this->errorInfo    = $statement->errorInfo();
    $this->columnCount  = $statement->columnCount();
    $this->affectedRows = $statement->rowCount();
  }

  public function rowCount() 
  {
    if ($this->hasRows()) {
      return count($this->rows);
    } else {
      return $this->affectedRows;
    }
  }

  public function hasRows()
  {
    if (empty($this->rows)) {
      return false;
    } else {
      return true;
    }
  }

  public function getRows() 
  {
    return $this->rows; 
  }

  public function getAffectedRows() 
  {
    return $this->affectedRows; 
  }

  public function getErrorCode() 
  {
    return $this->errorCode; 
  }

  public function getErrorInfo() 
  {
    return $this->errorInfo; 
  }

  public function getColumnCount() 
  {
    return $this->columnCount; 
  }

  // ArrayAccess implementation
  // =======================================

  public function offsetExists($offset)
  {
    return isset($this->rows[$offset]);
  }

  public function offsetSet($offset, $value)
  {
    $this->rows[$offset] = $value;
  }

  public function offsetGet($offset)
  {
    return $this->rows[$offset];
  }

  public function offsetUnset($offset)
  {
    unset($this->rows[$offset]);
  }



  // IteratorAggregate implementation
  // =======================================

  public function getIterator()
  {
    return new ArrayIterator($this->rows);
  }

}
