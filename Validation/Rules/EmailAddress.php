<?php

namespace Validation\Rules;

class EmailAddress extends Format
{
  protected static $defaultErrorMsg = 'Please enter a valid email address';
  protected $pattern = '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/';
  
  protected function checkInput($input)
  {
    if(parent::checkInput($input))
    {
      // peel off the domain name from the email address
      $fragments = explode('@', $input);
      $host = array_pop($fragments);
      // verify email address is in DNS records
      if(checkdnsrr($host))
      {
        return true;
      }
      else
      {
        $this->errorMsg .= " (host name provided not found)";
      }
    }
    return false;
  }
  
}