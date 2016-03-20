<?php

namespace App;

use Lib\Core\Object;

class Post extends Object
{
  /**
   * @var int
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
   * @var PostDataGateway  Data access object
   */
  protected $gateway;

  public function __construct($id = null)
  {
    $this->gateway = new PostDataGateway();

    if (isset($id)) {
      $this->load($id);
    }
  }

  /**
   * Fills fields with data from existing post.
   * 
   * @param int $id  Id number of existing post
   */
  public function load($id)
  {
    $data = $this->gateway->findById($id);

    if (empty($data)) {
      throw new Exception('Post not found.');
    }

    $this->id       = $id;
    $this->details  = $data['details'];
    $this->postDate = $data['date_posted'];
    $this->postTime = $data['time_posted'];
    $this->editDate = $data['date_edited'];
    $this->editTime = $data['time_edited'];
    $this->isPublic = $data['public'];
  }

  //
  // Accessor methods
  //

  public function getId()        { return $this->id;       }

  public function getDetails()   { return $this->details;  }

  public function getPostDate()  { return $this->postDate; }

  public function getPostTime()  { return $this->postTime; }

  public function getEditDate()  { return $this->editDate; }

  public function getEditTime()  { return $this->editTime; }

  public function isPublic()     { return $this->isPublic; }

  /**
   * Sets content and timestamps Post
   * 
   * @param string $details  Post content
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
  }

  /**
   * Set access level of post. 
   * 
   * @param string $access             Access level
   * @throws InvalidArgumentException  If a value other than 'public' or 
   *                                    'private' is passed. 
   */
  public function setIsPublic($value) 
  { 
    if (!is_bool($value)) {
      throw new InvalidArgumentException('isPublic value must be boolean.');
    }
  }

  public function toArray()
  {
    $postInfo = [
      'id'       => $this->id,
      'details'  => $this->details,
      'postDate' => $this->postDate,
      'postTime' => $this->postTime,
      'editDate' => $this->editDate,
      'editTime' => $this->editTime,
      'isPublic' => $this->isPublic
    ];

    return $postInfo;
  }

  // @throws Exception  If $details is blank
  // @todo: make more appropriate Exception class
  // @throws PDOException  If there is a database error from $gateway
  public function save()
  {
    // Make sure post is not blank
    if (empty($this->details)) {
      throw new Exception('Post cannot be blank');
    }

    try {
      // Check if new or existing post
      if (isset($this->id)) {
        $this->gateway->update($this->toArray());
      } else {
        $this->gateway->add($this->toArray());
      }
    } catch (PDOException $e) {
      throw $e;
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
