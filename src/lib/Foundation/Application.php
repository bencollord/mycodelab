<?php

namespace MyCodeLab\DI;

use Closure;
use MyCodeLab\System\{Object, NotFoundException};
use MyCodeLab\DI\Binding;

/**
 * Dependency injection container.
 * 
 * Currently only supports binding via closures, 
 * but will eventually be extended. 
 * 
 * @todo: Add features:
 *        - Bind interfaces to implementations
 *        - Build from arrays
 *        - Define a factory method to replace constructor
 */
class Application extends Object
{
  const ENV_DEV   = 'dev';
  const ENV_TEST  = 'testing';
  const ENV_STAGE = 'staging';
  const ENV_PROD  = 'production';
  
  /**
   * @var string Current deployment environment.
   */
  protected $environment;
  
  /**
   * @var string 
   */
  protected $domainName;
  
  /**
   * @var string
   */
  protected $rootDir;
  
  /**
   * @var string
   */
  protected $timezone;
  
  /**
   * @var bool
   */
  protected $debug;
  
  /**
   * @var DI\ComponentBinding[] Component resolutions.
   */
  protected $components;
  
  /**
   * @var array Shared component instances.
   */
  protected $instances;
  
  public function __construct(array $config = array())
  {
    $this->rootDir      = $config['root']        ?? null;
    $this->environment  = $config['environment'] ?? null;
    $this->domainName   = $config['domain']      ?? null;
    $this->debug        = $config['debug']       ?? null;
    $this->timezone     = $config['timezone']    ?? null;
  }

  public function bind($key, Closure $resolution, $shared = false)
  {
    $binding = new ComponentBinding($key, $resolution);
    
    if ($shared === true) {
      $this->instances[$key] = $binding->forge();
    }

    $this->components[$key] = new ComponentBinding($key, $resolution);
    
    return $this;
  }

  public function load($key)
  {
    if (array_key_exists($key, $this->instances)) {
      return $this->instances[$key];
    }
    if (array_key_exists($key, $this->bindings)) {
      return $this->components[$key]->forge();
    }
    
    throw new NotFoundException("No component with name '$key' has been registered.");
  }

}