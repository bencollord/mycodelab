<?php

namespace App\Model;

use Lib\Core\Object;
use Lib\Domain\Entity;

class Post extends Object implements Entity
{
  const TABLE = 'listtbl';

  const COLUMN_MAP = [
    'id'        => 'id',
    'details'   => 'details',
    'postDate'  => 'date_posted',
    'postTime'  => 'time_posted',
    'editDate'  => 'date_edited',
    'editTime'  => 'time_edited',
    'isPublic'  => 'public'
  ];

  /**
   * @var int  Post's unique identification key. If empty, indicates a new Post
   */
  protected $id;

  /**
   * @var string  The body of the post
   */
  protected $details;

  /**
   * @var string  Date post was created
   */
  protected $postDate;

  /**
   * @var string  Time post was created
   */
  protected $postTime;

  /**
   * @var string  Date of last edit
   */
  protected $editDate;

  /**
   * @var string  Time of last edit
   */
  protected $editTime;

  /**
   * @var bool
   */
  protected $isPublic;

  /**
   * Finds the first Post matching the specified criteria
   * 
   * @param string $field  The property you want to search by.
   * @param mixed  $value  The criteria to match.
   *                                       
   * @return Post
   */
  public static function load($id)
  {
    $result = (new PostDataGateway)->select('id', $id);

    foreach (static::COLUMN_MAP as $property => $column) {
      $post->$property = $result[$column];
    }

    return $post;
  }

  /**                                     
   * @return Post[]
   */
  public static function loadAll($filter = null) 
  {
    $gateway = new PostDataGateway();

    // @todo: find a cleaner way of doing this
    switch ($filter) {
      case 'public': 
        $result = $gateway->select('public', true);
        break;
      default: 
        $result = $gateway->select();
    }

    foreach ($result as $row) {
      $post = new Post();

      foreach (static::COLUMN_MAP as $property => $column) {
        $post->$property = $row[$column];
      }

      $posts[] = $post;
    }

    return $posts;
  }

  //
  // Accessor methods
  //

  public function getId()        
  { 
    return $this->id;      
  }

  public function getDetails()   
  {
    return $this->details;  
  }

  /**
   * Sets content and timestamps Post
   * 
   * @param string $details  Post content
   *                              
   * @return $this
   */
  public function setDetails($details) 
  { 
    $time = strftime("%X");
    $date = strftime("%Y %B %d");

    $this->details  = $details;
    $this->editTime = $time;
    $this->editDate = $date;

    // Set original posting time for new posts
    if (!isset($this->id)) {
      $this->postTime = $time;
      $this->postDate = $date;
    }
    
    return $this;
  }

  public function getPostDate()  
  {
    return $this->postDate; 
  }

  public function getPostTime()  
  {
    return $this->postTime; 
  }

  public function getEditDate()  
  {
    return $this->editDate; 
  }

  public function getEditTime()  
  {
    return $this->editTime; 
  }

  public function getIsPublic()  
  {
    return $this->isPublic; 
  }


  /**
   * Set access level of post. 
   * 
   * @param bool $value
   *                                          
   * @throws InvalidArgumentException  If a value other than 'public' or 
   *                                    'private' is passed. 
   *                                    
   * @return $this
   */
  public function setIsPublic($value) 
  { 
    if (!is_bool($value)) {
      throw new InvalidArgumentException('isPublic value must be boolean.');
    }
    
    return $this;
  }

  public function toArray()
  {
    $postData = [
      'id'       => $this->id,
      'details'  => $this->details,
      'postDate' => $this->postDate,
      'postTime' => $this->postTime,
      'editDate' => $this->editDate,
      'editTime' => $this->editTime,
      'isPublic' => $this->isPublic
    ];

    return $postData;
  }

  public function save()
  {
    // Make sure post is not blank
    if (empty($this->details)) {
      throw new Exception('Post cannot be blank');
    }

    // Check if new or existing post
    if (isset($this->id)) {
      $this->gateway->update($this->toArray());
    } else {
      $this->gateway->add($this->toArray());
    }
  }

  // @throws PDOException  If there is a database error from $gateway
  public function delete() 
  {
    try {
      $this->gateway->delete($this->id);
    } catch (PDOException $e) {
      throw $e;
    }
  }

}
