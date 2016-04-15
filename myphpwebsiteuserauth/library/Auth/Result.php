<?php
 
namespace Library\Auth;

use Library\System\Object;

class Result extends Object
{
  /**
   * Numeric result code constants
   */
  const FAIL_NOT_FOUND  = -1;
  const FAIL_INVALID    =  0;
  const SUCCESS         =  1;
  
  /**
   * @var int The numeric code matching the result
   */
  private $code;
  
  /**
   * @var string A descriptive string of the result
   */
  private $message;
  
  public function __construct($code, $message = '')
  {
    $this->code     = $code;
    $this->message  = $message;
  }
  
  /**
   * Check if Authentication passed
   * 
   * @return bool
   */
  public function isValid()
  {
    if ($this->code === 1) {
      return true;
    } else {
      return false;
    }
  }
  
  /**
   * Get descriptive message about auth attempt
   * 
   * @return string
   */
  public function getMessage()
  {
    return $this->message;
  }
  
}
