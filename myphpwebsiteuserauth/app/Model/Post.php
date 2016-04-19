<?php

namespace App\Model;

use DateTime;
use DomainException;
use Lib\System\Object;

class Post extends Object
{
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
    $result = (new PostDataGateway())->select('id', $id);

    if ($result->isEmpty()) {
      return false; 
    }

    $post = new Post();
    
    $post->id       = $result['id'];
    $post->details  = $result['details'];
    $post->postTime = new DateTime($result['date_posted'] . ' ' . $result['time_posted']);
    $post->editTime = new DateTime($result['date_edited'] . ' ' . $result['time_edited']);
    $post->isPublic = $result['public'];

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

      $post->id       = $result['id'];
      $post->details  = $result['details'];
      $post->postTime = new DateTime($result['date_posted'] . ' ' . $result['time_posted']);
      $post->editTime = new DateTime($result['date_edited'] . ' ' . $result['time_edited']);
      $post->isPublic = $result['public'];

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
    $timestamp     = new DateTime();
    
    $this->editTime = $timestamp;

    if (!isset($this->postTime)) {
      $this->postTime = $timestamp;
    }

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
   * @throws InvalidArgumentException                          
   *                                    
   * @return $this
   */
  public function setPublic($value) 
  { 
    if (!is_bool($value)) {
      throw new InvalidArgumentException('isPublic value must be boolean.');
    }
    
    $this->isPublic = $value;

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
    $data = $this->toArray();
    
    // Format DateTime into strings for Gateway
    $data['postTime'] = $this->postTime->format('Y-m-d');
    $data['postDate'] = $this->postTime->format('H:i:s');
    $data['editTime'] = $this->editTime->format('Y-m-d');
    $data['editDate'] = $this->editTime->format('H:i:s');
    
    // Make sure post is not blank
    if (empty($this->details)) {
      throw new DomainException('Post cannot be blank');
    }

    // Check if new or existing post
    if (isset($this->id)) {
      $this->gateway->update($data);
    } else {
      $this->gateway->insert($data);
    }
  }

  public function delete() 
  {
    $this->gateway->delete($this->id);
  }

}
