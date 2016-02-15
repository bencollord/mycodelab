<?php

class Application
{
  private $dbConnection;
  private $router;
  private $request;
  private $document;
  
  private static $instance;

  private function __construct() {}

  private function __clone() {}

  public static function getInstance()
  {
    if (!isset(self::$instance))
    {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function init(Router $router, HtmlDocument $document)
  {
    $this->router   = $router;
    $this->document = $document;
  }

  public function execute(Request $rqst)
  {
    $request    = $this->router->route($rqst);
    $controller = $request->getController();
    $action     = $request->getAction();
    $params     = $request->getParams();

    $page = $controller->{$action}($params);
    $this->html->setPage($page);
    $this->html->render();
  }

}
