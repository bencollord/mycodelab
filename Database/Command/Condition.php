<?php

/**
 * Represents WHERE and HAVING clauses in SQL
 */
class Condition
{
  const OPERATORS = ['=', '!=', '>', '<', '<=', '>=', 'between', 'like', 'in'];
  
  protected $conditions = array();
  
  protected $parameters = array();
  
}