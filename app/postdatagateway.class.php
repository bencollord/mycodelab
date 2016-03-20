<?php

namespace App;

use Lib\Core\Object;

class PostDataGateway extends Object
{
  /**
   * Database table constant
   */
  const TABLE = 'listtbl';

  /**
   * @var PDO - TODO: encapsulate functionality in database class
   * */
  protected $dbConn;

  public function __construct() 
  {
    $this->dbConn = Database::forge();
  }

  public function findById($id) 
  {
    $stmt = $this->dbConn->prepare("SELECT * FROM listtbl WHERE id=:id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row;
  }

  /**
   * Get data from all posts in the table
   * 
   * @return array[] - All returned rows as associative arrays
   */
  public function findAll() 
  {
    $stmt = $this->dbConn->query("SELECT * FROM listtbl");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $rows;
  }

  /**
   * Get data from all public posts in the table
   * 
   * @return array[] - All returned rows as associative arrays
   */
  public function findPublic() 
  {
    $stmt = $dbConn->query("SELECT * FROM listtbl WHERE public=1");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $rows;
  }

  public function add($postData)
  {
    $stmt = $this->dbConn->prepare("INSERT INTO listtbl (details, date_posted, time_posted, date_edited, time_edited, public) VALUES (:details, :date_posted, :time_posted, :date_edited, :time_edited, :public)");

    try {
      $stmt->bindParam(':details'    , $postData['details']);
      $stmt->bindParam(':time_posted', $postData['postTime']);
      $stmt->bindParam(':date_posted', $postData['postDate']);
      $stmt->bindParam(':time_edited', $postData['editTime']);
      $stmt->bindParam(':date_edited', $postData['editDate']);
      $stmt->bindParam(':public'     , $postData['isPublic']);
      $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    } 
  }

  public function update($postData) 
  {
    $stmt = $this->dbConn->prepare("UPDATE listtbl SET details=:details, public=:public, date_edited=:date, time_edited=:time WHERE id=:id");

    try {
      $stmt->bindParam(':id'     , $postData['id']);
      $stmt->bindParam(':details', $postData['details']);
      $stmt->bindParam(':public' , $postData['isPublic']);
      $stmt->bindParam(':date'   , $postData['editDate']);
      $stmt->bindParam(':time'   , $postData['editTime']);
      $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    }
  }

  public function delete($postId) 
  {
    try {
      $stmt = $this->dbConn->prepare("DELETE FROM listtbl WHERE id=:id");
      $stmt->bindParam(':id', $postId);
      $stmt->execute();
    } catch (PDOException $e) {
      throw $e;
    }
  }

}

