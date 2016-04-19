<?php

namespace App\Model;

use DateTime;
use DomainException;
use Lib\System\Object;

class Post extends Object
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
   * @var int  Post's unique identification key. If empty, indicates a new Post.
   */
  protected $id;

  /**
   * @var string  The body of the post
   */
  protected $details;

  /**
   * @var \DateTime  Timestamp of post creation
   */
  protected $postTime;

  /**
   * @var \DateTime  Timestamp of last edit
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
   * @return Post|false
   */
  public static function load($id)
  {
    $result = (new PostDataGateway)->select('id', $id);

    if ($result->isEmpty()) {
      return false; 
    }

    foreach (static::COLUMN_MAP as $property => $column) {
      $post->$property = $result[$column];
    }

    return $post;
  }

  /**                                     
   * @return Post[]|false
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

    if (empty($result)) { 
      return false; 
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

  public function __construct()
  {
    $this->gateway = new PostDataGateway();
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
    $this->details = $details;

    return $this;
  }

  public function getPostTime()  
  {
    return $this->postTime; 
  }

  public function getEditTime()  
  {
    return $this->editTime; 
  }

  public function getPublic()  
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
  public function setPublic($value) 
  { 
    if (!is_bool($value)) {
      throw new InvalidArgumentException('isPublic value must be boolean.');
    }

    return $this;
  }

  /**
   * Alias for getPublic
   * 
   * @return bool
   */
  public function isPublic()  
  {
    return $this->isPublic; 
  }

  public function toArray()
  {
    $rawData = [
      'id'       => $this->id,
      'details'  => $this->details,
      'postTime' => $this->postTime,
      'editTime' => $this->editTime,
      'isPublic' => $this->isPublic
    ];

    return $rawData;
  }

  public function save()
  {
    // Make sure post is not blank
    if (empty($this->details)) {
      throw new DomainException('Post cannot be blank');
    }

    $time = new DateTime();

    // Set original posting time for new posts
    if (!isset($this->id)) {
      $this->postTime = $time;
    }
    
      $this->editTime = $time;

    // Check if new or existing post
    if (isset($this->id)) {
      $this->gateway->update($this->toArray());
    } else {
      $this->gateway->insert($this->toArray());
    }
  }

  // @throws PDOException  If there is a database error from $gateway
  public function delete() 
  {
    $this->gateway->delete($this->id);
  }

}
