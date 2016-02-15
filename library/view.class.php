<?php 

class View 
{
  protected $title;
  protected $template;
  protected $stylesheets = array();
  protected $embeddedCss;
  protected $scripts     = array();
  protected $embeddedJs;
  protected $vars        = array();

  public function __construct($title, $template) 
  {
    $this->title    = $title;
    $this->template = $template;
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
   */
  public function setTitle($title)
  {
    $this->title = $title;
  }

  /**
   * Set content of $vars array
   * Replaces the existing array
   *
   * @param array $variables
   */
  public function setVars(array $vars)
  {
    $this->vars = $vars;
  }

  /**
   * Add a single variable to the $vars array
   * 
   * @param string $key
   * @param mixed $value
   * @return void
   */
  public function addVar($key, $value)
  {
    $this->vars[$key] = $value;
  }

  /**
   * Append array of variables to the $vars array.
   * Duplicate keys in the new array will override the originals
   * 
   * @param array $variables
   * @return void
   */
  public function addVars(array $variables) 
  {
    $this->vars = array_merge($this->vars, $variables);
  }

  /**
   * Clears all data from $vars array. 
   */
  public function clearVars()
  {
    unset($this->vars);
  }

  public function render()
  {
    foreach($this->vars as $key => $value){
      $this->$key = $value;
    }
    include $this->template;
  }

}