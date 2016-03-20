<?php 

namespace Lib\View;

use Lib\Core\Object;

class HtmlDocument extends Object implements View
{
  protected $title;
  protected $template;
  protected $blocks      = array();
  protected $metaTags    = array();
  protected $stylesheets = array();
  protected $scripts     = array();
  
  public function __construct($template, $stylesheets = array(), $scripts = array())
  {
    $this->template     = $template;
    $this->stylesheets  = $stylesheets;
    $this->scripts      = $scripts;
  }

  /**
   * @return string $this->title
   */
  public function getTitle() 
  {
    return $this->title;
  }

  /**
   * @param string $title
   * @return $this
   */
  public function setTitle($title)
  {
    $this->title = $title;
    
    return $this;
  }
  
  /**
   * [[Description]]
   * @return $this
   */
  public function addMeta($name, $value) 
  { 
    // @todo: method body
    
    return $this; 
  }
  
  /**
   * [[Description]]
   * @return $this
   */
  public function addStylesheet($path, $handle = null) 
  { 
    // @todo: method body
    
    return $this; 
  }
  
  /**
   * [[Description]]
   * @return $this
   */
  public function addScript($path, $handle = null) 
  { 
    // @todo: method body
    
    return $this; 
  }
  
  

  public function render()
  {
    extract($this->blocks);
    ob_start();
    include $this->template;
    return ob_get_clean();
  }

}