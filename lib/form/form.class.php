<?php

namespace Form;

class Form extends Block
{
  /**
   * @var string[] - Any metadata the form or it's descendents may need as an 
   *                 associative array, such as a heading or description
   */
  protected $metadata = array();
  /**
   * @var Field[] - Array of form input field objects
   */
  protected $fields   = array();
  /**
   * @var bool - Whether or not all fields have passed validation Default value 
   *             of NULL allows it to aditionally be used to check if validation
   *             has been run
   */
  protected $validStatus = NULL; 
  
  public function __construct($metadata = array())
  {
    $this->metadata = $metadata;  
  }
  
  /**
   * Add an input field to the form
   * 
   * @param string   $name  - Unique identifier 
   * @param string   $type  - The class/template that will be used
   * @param string[] $rules - Associative array of Validation parameters
   */
  public function addField($name, $type, array $rules)
  {
    $this->fields[$name] = Field::build($name, $type, $rules);
  }
  
  /**
   * Populates form with input via $_POST or other assoc. array
   * 
   * @todo: Long method. Refactor to something cleaner
   * @param array $input - name/value pairs of form input
   * @return void
   */
  public function process(array $input){
    //fill fields with data
    foreach($input as $key => $value)
    {
      if(array_key_exists($key, $this->fields))
      {
        $this->fields[$key]->input($value);
      }
    }
    
    //run validation for each field
    $numFailed = 0;
    foreach($this->fields as $field)
    {
      if(!$field->isValid)
      {
        $numFailed++;
      }
    }
    
    if($numFailed === 0)
    {
      $this->validStatus = true;
      return true;
    }
    else
    {
      $this->validStatus = false;
      return false;
    }
  }
  
  /**
   * Accessor for $validationStatus
   * 
   * @return bool
   */
  public function isValid()
  {
    return $this->validStatus;
  }
  
  /**
   * Render form to HTML. Extracts fields
   * from $fields so they can be rendered in 
   * the template
   * 
   * @param string $template - filename of template
   * @return void
   */
  public function render()
  {
    extract($this->fields);
    ob_start();
    include_once $this->template;
    return ob_get_clean();
  }
  
  /**
   * Sends the contact form data as an email
   * 
   * @todo - Highly coupled. Refactor to something more flexible. 
   *         (Considering a callback)
   * 
   * @param mixed $sendTo - string or array containing recipient email addresses
   * @return bool         - returns true upon success, or false upon failure
   */
  public function send($sendTo)
  {
    if(!$this->isValid())
    {
      return false;
    }
    $name    = $this->fields['name'];
    $email   = $this->fields['email'];
    $subject = $this->metadata['subject'];
    $body    = $this->fields['message'];
        
    $message = new Message();
    $message->setSender($email, $name)
            ->setSubject($subject)
            ->setBody($body)
            ->addRecipient($sendTo)
            ->send();
    return true;
  }
  
}