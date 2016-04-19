<?php

use Lib\System\Autoloader;
use Lib\Http\{Request, Response, Session};
use Lib\Database\{Connection, SqlCommand};
use Lib\Auth\{User, Result as AuthResult};

// Define configuration constants
require_once 'config.php';

// Register autoloader
require_once 'library/System/Autoloader.php';

Autoloader::register();


// Mock user info
// =============================================================================

$credentials = [
  'username' => 'TestUser',
  'password' => 'Password'
];


// Auth Process Outline
// =============================================================================

$dbConn    = Connection::forge();
$session   = new Session();
$request   = new Request(['post' => ['credentials' => $credentials]]);
$response  = new Response(); // Only needed for test


$session->start();

$result = login($dbConn, $session, $request);

if (checkLogin($session)) {
  echo $session->read('user');
} else {
  echo "Not logged in. Reason: $result->message";
}

function login($dbConn, $session, $request)
{
  if (checkLogin($session)) {
    echo "You're already logged in, " . $session->read('user') . "!";
    exit;
  }
  
  // Get sent info from request
  $login = $request->readPost('credentials');

  // Find matching user
  $user = User::find($login['username']);

  if (!$user) {
    return new AuthResult(AuthResult::FAIL_NOT_FOUND, 'Invalid Username');
  }
  
  if (!$user->matchPassword($login['password'])) {
    return new AuthResult(AuthResult::FAIL_INVALID, 'Invalid Password');
  }
  
  $session->write('user', $user->username);
  
  return new AuthResult(AuthResult::SUCCESS);
}



// Register
// =============================================================================

function register($dbConn, $request)
{
  $credentials = $request->readPost('credentials');
  $user        = new User($credentials['username'], $credentials['password']);
  
  try {
    $user->save();
    echo "Registered user successfully!";
  } catch (Exception $e) {
    die ($e->getMessage());
  }
  
  if ($dbResult->affectedRows > 0) {
    return true;
  } else {
    echo "There was a problem registering the user";
    return false;
  }
}

// Check for logged in user
// =============================================================================

function checkLogin($session)
{
  if ($session->hasKey('user')) {
    echo "Logged in as " . $session->read('user') . "!";
    return true;
  } else {
    echo "Nope...";
    return false;
  }
}



