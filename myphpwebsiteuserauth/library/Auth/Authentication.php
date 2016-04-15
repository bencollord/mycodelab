<?php

/**
 * Provides general membership facilities. 
 * Creates a new user.
 * Deletes a user.
 * Updates a user with new information.
 * Returns a list of users.
 * Finds a user by name or e-mail.
 * Validates (authenticates) a user.
 * Gets the number of users online.
 * Searches for users by username or e-mail address
 */

namespace Library\Authentication;

use Library\Foundation\{Object, Request, Session};
use Library\Database\SqlCommand;

/**
 * Manages and tracks user logins and access privileges.
 */
class Authentication extends Object
{
  /** 
   * @var Library\Foundation\Request
   */
  protected $request;
  
  /** 
   * @var Library\Foundation\Session
   */
  protected $session;
  
  public function __construct(Request $request, Session $session)
  {
    $this->request = $request;
    $this->session = $session;
  }
  
  public function run(Identity $user)
  {
    
  }  
  
}