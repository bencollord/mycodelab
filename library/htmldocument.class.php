<?php 

class HtmlDocument
{
  private $template;
  private $layout;
  private $content;
  private $stylesheets = array();
  private $scripts     = array();
  
  public function __construct($template, $assets = NULL) 
  {
    $this->template = $template;
    $this->layout   = $layout;
    
    if(isset($assets))
    {
      extract($assets);
      if(isset($stylesheets))
      {
        $this->stylesheets = $stylesheets;
      }
      if(isset($scripts)) 
      {
        $this->scripts = $scripts;
      }
    }
  }
  
  

}