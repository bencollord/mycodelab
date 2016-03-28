<?php

namespace Lib\View\Grid;

use Lib\Core\Object;

class GridColumn extends Object
{  
  /**
   * @var GridView  The instance that contains this column.
   */
  protected $grid;
  
  /** 
   * @var string  The the data source field that will be used for content
   */
  protected $dataKey;
  
  /**
   * @var string  The output in the heading cell.
   */
  protected $heading;
  
  /**
   * @var Closure  Callback function to format the output.
   */
  protected $format;
  
  /**
   * @var bool  Whether or not this column will be rendered by the view.
   */
  protected $visible;
  
  public function __construct(GridView $grid, $dataKey, $options = array())
  {
    $this->grid    = $grid;
    $this->dataKey = $dataKey;
    $this->format  = $options['format']  ?? null;
    $this->heading = $options['heading'] ?? null;
  }
  
  public function hide() 
  {
    $this->visible = false; 
    
    return $this;
  }
  
  public function show()
  { 
    $this->visible = true; 
    
    return $this;
  }
  

  // Accessors
  // ===========================================================================
  
  public function getDataKey()          
  {
    return $this->dataKey;   
  }
  
  public function getHeading()       
  {
    return $this->heading ?? $this->dataKey;
  }
  
  public function setHeading($value) 
  {
    $this->heading = (string)$value; 
    
    return $this;
  }
  
}