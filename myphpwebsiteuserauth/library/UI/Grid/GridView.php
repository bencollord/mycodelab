<?php

namespace Library\View\Grid;

use Library\System\Object;
use \ArrayObject;

class GridView extends Object implements Renderable
{
  /**
   * Read mode constants.
   */
  const READ_ARRAY  = 0;
  const READ_OBJECT = 1;

  /**
   * @var int Class constant value indicating how data should be parsed.
   */
  protected $readMode;

  /**
   * @var string The title of the GridView. Will be rendered as the heading.
   */
  protected $title;

  /**
   * @var GridColumn[] Collection of GridColumn objects. Implemented as an
   *                   anonymous implementation of ArrayAccess for type hinting.
   */
  protected $columns;

  /**
   * @var object[]|array[]  The items in the data set. Can be an associative
   *                        array or a collection of objects.
   */
  protected $dataSet;

  /**
   * @var string  The template file to be rendered.
   */
  protected $template;

  public function __construct($readMode = self::READ_ARRAY)
  {
    $this->readMode = $readMode;
    $this->columns  = $this->initColumnCollection();
  }


  // Define columns
  // ===========================================================================

  public function bind(array $dataSet, array $columnNames)
  {
    $dataSample = $dataSet[0];
    
    if (is_object($dataSample)) {
      $fields = $this->extractObjectFields($dataSample);
    } elseif (is_array($dataSample)) { 
      $fields = $this->extractAssocFields($dataSample);
    } else {
      throw new InvalidArgumentException('GridView cannot read data source');
    }
    
    // @todo: Finish binding logic
  }

  public function addColumn($name, $boundField, $headingText = null) 
  {
    $this->columns[] = new GridColumn($this, $name, $boundField, $headingText);
    
    return $this;
  }


  // Manipulate row collection
  // =========================================================================== 

  public function fill(array $items) 
  {
    // Make sure items match current read mode
    array_walk($items, [$this, 'checkInput']);

    $this->dataSet = $items;
    
    return $this;
  }

  public function clear()
  {
    $this->dataSet = array();
    
    return $this;
  }

  public function push($item) 
  {
    if ($this->checkInput($item)) {
      array_push($this->dataSet, $item);
    }
    
    return $this;
  }

  public function pop() 
  {
    return array_pop($this->dataSet);
  }

  public function shift() 
  {
    return array_shift($this->dataSet);
  }

  public function unshift($item) 
  {
    if ($this->checkInput($item)) {
      array_unshift($this->dataSet, $item);
    }
    
    return $this;
  }


  // Render output
  // ===========================================================================

  public function render()
  {

  }


  // Accessors
  // ===========================================================================

  public function getTitle()                
  {
    return $this->title;    
  }

  public function setTitle(string $title)  
  { 
    $this->title = $title;  
    
    return $this;
  }

  public function getTemplate()             
  {
    return $this->template;  
  }

  public function setTemplate(string $file) {
    $this->template = $file; 
  
    return $this; 
  }

  public function getColumns()             
  {
    return $this->columns;  
  }

  public function getReadMode() : int      
  { 
    return $this->readMode;
  }

  public function setReadMode(int $mode)
  {
    if ($mode !== static::READ_ARRAY || $mode !== static::READ_OBJECT) {
      throw new InvalidArgumentException('Invalid read mode for GridView.');
    }

    $this->readMode = $mode; 
    
    return $this;
  }


  // Utility Methods
  // ===========================================================================

  /**
   * Defines and returns an anonymous ArrayObject that enforces type checking.
   * 
   * @return ArrayObject
   */
  private function initColumnCollection()
  {
    return new class () extends ArrayObject {

      public function append($value) {
        // Check type of items added to array
        if (!$value instanceof GridColumn) { 
          throw new InvalidArgumentException('Value passed to $columns must be an instance of GridColumn'); 
        }

        parent::append($value);
      }

      public function offsetSet($offset, $value) {
        if (!$value instanceof GridColumn) { 
          throw new InvalidArgumentException('Value passed to $columns must be an instance of GridColumn'); 
        }

        parent::offsetSet($offset, $value);
      }
    };
  }

  private function extractObjectFields($object)
  {
    $properties = (new ReflectionClass($object))->getProperties();
    $fields     = array();

    foreach ($properties as $property) {
      $propName   = $property->getName();
      $fields[] = $object->canReadProperty($propName) ? $propName : null;
    }

    return $fields;
  }

  private function extractAssocFields(array $array)
  {
    $fields = array_keys($array);

    return $fields;
  }


  private function checkInput($input)
  {
    // @todo: write more descriptive exception message
    if ($this->readMode == static::READ_ARRAY && !is_array($value)) {
      throw new InvalidArgumentException("Cannot read item when read mode is array.");
    }
    if ($this->readMode == static::READ_OBJECT && !is_object($value)) {
      throw new InvalidArgumentException("Cannot read item when read mode is object.");
    }

    return true;
  }


}