<?php

namespace MyCodeLab\Foundation;

use MyCodeLab\System\{Object, NotFoundException};
use MyCodeLab\Dependency\Registry;

/**
 * Represents a web application.
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
   * @var MyCodeLab\Dependency\Registry
   */
  protected $registry;
  
  public function __construct(array $config = array(), Registry $registry = null)
  {
    $this->registry    = $registry ?? new Registry();
    
    $this->rootDir     = $config['root']        ?? null;
    $this->environment = $config['environment'] ?? null;
    $this->domainName  = $config['domain']      ?? null;
    $this->debug       = $config['debug']       ?? null;
    $this->timezone    = $config['timezone']    ?? null;
  }
  
  /**
   * @param  MyCodeLab\Http\Request $request
   * 
   * @return MyCodeLab\Http\Response
   */
  public function run(Request $request)
  {
    $route    = $this->routeMap->match($request->uri->getPath());
    $response = $route->dispatch($request);
    
    return $response;
  }

}