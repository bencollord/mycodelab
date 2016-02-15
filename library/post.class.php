<?php

class Post 
{
  private $id;
  private $details;
  private $postDate;
  private $postTime;
  private $editDate;
  private $editTime;
  private $isPublic;
  //@todo: remove these 2 properties and replace with database abstraction class and exception respectively
  private $dbConn;
  private $message;

  public static function getAllPosts()
  {
    $dbConn = PDOFactory::getPDO();
    $query = $dbConn->query("SELECT * FROM listtbl");

    while($row = $query->fetch())
    {
      $posts[] = new Post($row['id']);
    }
    return $posts;
  }

  public static function getPublicPosts() {
    $dbConn = PDOFactory::getPDO();
    $posts  = array();
    $query  = $dbConn->query("SELECT * FROM listtbl WHERE public=1");

    while($row = $query->fetch()) 
    {
      $posts[] = new Post($row['id']);
    }
    return $posts;
  }

  public function __construct($id=null) 
  {
    $this->dbConn = PDOFactory::getPDO();
    //sets all properties to match db data
    if(!empty($id)){
      $this->id = $id;
      $stmt = $this->dbConn->prepare("SELECT * FROM listtbl WHERE id=:id");
      $stmt->bindParam(':id', $this->id);
      $stmt->execute();
      $row = $stmt->fetch();

      $this->details  = $row['details'];
      $this->postDate = $row['date_posted'];
      $this->postTime = $row['time_posted'];
      $this->editDate = $row['date_edited'];
      $this->editTime = $row['time_edited'];
      $this->isPublic = (bool)$row['public'];
    }
  }

  public function getId()              { return $this->id; }

  public function getDetails()         { return $this->details; }

  public function setDetails($details) { $this->details = $details; }

  public function getPostDate()        { return $this->postDate; }

  public function getPostTime()        { return $this->postTime; }

  public function getEditDate()        { return $this->editDate; }

  public function getEditTime()        { return $this->editTime; }

  public function getMessage()         { return $this->message; }

  public function isPublic()           { return $this->isPublic; }

  public function setIsPublic($public) { $this->isPublic = (bool)$isPublic; }

  public function toArray()
  {
    $array = get_object_vars($this);
    return $array;
  }

  public function add($details, $isPublic) 
  {
    $this->postTime = $this->editTime = strftime("%X");
    $this->postDate = $this->editDate = strftime("%Y %B %d");
    $this->details  = $details;
    $this->isPublic = $isPublic;

    if($this->isPublic == true){
      $tinyint = 1;
    } elseif($this->isPublic == false) {
      $tinyint = 0;
    } else {
      throw new InvalidArgumentException("Error: Argument must be a Boolean");
    }

    $stmt = $this->dbConn->prepare("INSERT INTO listtbl (details, date_posted, time_posted, date_edited, time_edited, public) VALUES (:details, :date_posted, :time_posted, :date_edited, :time_edited, :public)");

    try
    {
      $stmt->bindValue(':details', $this->details);
      $stmt->bindValue(':time_posted', $this->postTime);
      $stmt->bindValue(':date_posted', $this->postDate);
      $stmt->bindValue(':time_edited', $this->editTime);
      $stmt->bindValue(':date_edited', $this->editDate);
      $stmt->bindValue(':public', $tinyint);
      $stmt->execute();
    }
    catch (PDOException $e)
    {
      $this->message = 'Error saving post to database' . $e->getMessage();
    }
  }

  public function delete() 
  {
    try
    {
      $stmt = $dbConn->prepare("DELETE FROM listtbl WHERE id=:id"); //SQL query
      $stmt->bindParam(':id', $this->id);
      $stmt->execute();
    }
    catch (PDOException $e)
    {
      $this->message = 'Error deleting post from database' . $e->getMessage();
    }
  }

  public function edit($details, $isPublic)
  {
    $this->editTime = strftime("%X");
    $this->editDate = strftime("%Y %B %d");

    $stmt = $dbConn->prepare("UPDATE listtbl SET details=:details, public=:public, date_edited=:date, time_edited=:time WHERE id=:id"); //SQL query

    try
    {
      $stmt->bindParam(':details', $details);
      $stmt->bindParam(':public', $public);
      $stmt->bindParam(':date', $this->editDate);
      $stmt->bindParam(':time', $this->editTime);
      $stmt->bindParam(':id', $this->id);
      $stmt->execute();
    }
    catch (PDOException $e)
    {
      $this->message = 'Error saving post to database' . $e->getMessage();
    }
  }

}
