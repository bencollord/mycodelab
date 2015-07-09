<?php
require_once('db.inc.php');

class Post {
    private $id;
    private $details;
    private $postDate;
    private $postTime;
    private $editDate;
    private $editTime;
    private $isPublic;
    private $dbConn;

    public __construct($id=null) {
        //brings PDO '$dbConn' from db.inc.php to Post class
        $this->dbConn = $dbConn;
        //sets all properties to match db data
        if(!empty($id)){
          $this->id = $id;
          $stmt = $dbConn->prepare("SELECT * FROM listtbl WHERE id=:id");
          $stmt->bindParam(':id', $this->id);
          $stmt->execute();
          $row = $stmt->fetch();
          $this->details = $row['details'];
          $this->postDate = $row['date_posted'];
          $this->postTime = $row['time_posted'];
          $this->isPublic = $row['public'];
          if(!empty($row['date_edited'])) {
            $this->editDate = $row['date_edited'];
          }
          if(!empty($row['time_edited'])) {
            $this->editTime = $row['time_edited'];
          }
        }
    }

    public function getPostInfo() {
        $info = array(
          'id' => $this->id;
          'details' => $this->details;
          'post_time' => $this->postTime;
          'post_date' => $this->postDate;
          'edit_time' => $this->editTime;
          'edit_date' => $this->editDate;
          'is_public' => $this->isPublic;
        );
        return $info;
    }

    public function add($details, $isPublic) {
        $this->postTime = strftime("%X");
        $this->postDate = strftime("%Y %B %d");
        $this->details = $details;

        $stmt = $this->dbConn->prepare("INSERT INTO listtbl (details, date_posted, time_posted, public) VALUES (:details, :date, :time, :decision)");
        $stmt->bindValue(':details', $this->details);
        $stmt->bindValue(':time', $this->postTime);
        $stmt->bindValue(':date', $this->postDate);
        $stmt->bindValue(':decision', $this->isPublic);
        $stmt->execute();
    }

    public function delete() {
        $stmt = $dbConn->prepare("DELETE FROM listtbl WHERE id=:id"); //SQL query
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function edit($details, $isPublic) {
        $this->editTime = strftime("%X");
        $this->editDate = strftime("%Y %B %d");

        $stmt = $dbConn->prepare("UPDATE listtbl SET details=:details, public=:public, date_edited=:date, time_edited=:time WHERE id=:id"); //SQL query
        $stmt->bindParam(':details', $details);
        $stmt->bindParam(':public', $public);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt;
    }

}

?>
