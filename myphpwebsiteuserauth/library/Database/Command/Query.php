<?php

namespace Library\Database\Sql;

use Library\System\Object;
use Library\Database\Connection;

/**
 * Represents a SQL statement
 * 
 * @todo: add support for the following features:
 *        - aggregate functions 
 *        - unions
 *        - joins
 *        - limit 
 *        - offset
 *        - stored procedures
 */
abstract class Query
{
  /**
   * @var Connection  Link to database
   */
  protected $connection;
  
  /**
   * @var string  The raw SQL to be executed on the database
   */
  protected $sql;
  
  public function __construct(Connection $connection)
  {
    $this->connection = $connection;
  }

  abstract public function compile();
  
  abstract public function execute();

  abstract public function __toString();

}