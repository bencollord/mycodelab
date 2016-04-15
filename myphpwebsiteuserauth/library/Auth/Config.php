<?php

namespace Library\Auth;

use Library\System\Object;

class Config extends Object
{
  /**
   * @var string
   */
  protected $userTableName;
  
  public function getUserTableName()
  {
    return $this->userTableName;
  }
  
}