<?php

namespace MyCodeLab\Application;

use MyCodeLab\System\{Object, NotFoundException};
use MyCodeLab\Dependency\Registry;
use MyCodeLab\Routing\RouteMap;

/**
 * Represents a web application.
 */
class Kernel extends Object
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
  
  /**
   * @var MyCodeLab\Routing\RouteMap
   */
  protected $routeMap;
  
  public function __construct(Registry $components, RouteMap $routes, array $config = array())
  {
    $this->components   = $components;
    $this->routes       = $routes;
    $this->rootDir      = $config['root']        ?? null;
    $this->environment  = $config['environment'] ?? null;
    $this->domainName   = $config['domain']      ?? null;
    $this->debug        = $config['debug']       ?? null;
    $this->timezone     = $config['timezone']    ?? null;
  }
  
  
  /**
   * @param  MyCodeLab\Http\Request $request
   * 
   * @return MyCodeLab\Http\Response
   */
  public function dispatch(Request $request, Response $response)
  {
    $path = $request->url->path;
    
    try {
      $route = $this->routeMap->match($path);
      $route = $route->compile();
      
    } catch (RouteNotFoundException $e) {
      $response->setStatusCode(Response::STATUS_CODE['404'])
               ->write("There's nothing here. Sorry!");
    }
        
    return $response;
  }

}