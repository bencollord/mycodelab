<?php

namespace App\Model;

use Lib\System\Object;
use Lib\Database\{Connection, SqlCommand};

class PostDataGateway extends Object
{
  /**
   * Database table constant
   */
  const TABLE = 'listtbl';

  /**
   * @var Connection
   */
  protected $connection;

  public function __construct() 
  {
    $this->connection = Connection::forge();
  }

  /**
   * Get data from all posts in the table
   * 
   * @return array[] - All returned rows as associative arrays
   */
  public function select($column = null, $value = null) 
  {
    $sql      = "SELECT * FROM " . static::TABLE;
    $command  = new SqlCommand();
    
    $command->write($sql);
    
    if ($column && $value) {
      $command->append("WHERE $column=:$column", [$column => $value]);
    }
    
    $rows = $command->executeQuery();

    return $rows;
  }

  public function insert($postData)
  {
    $sql    = "INSERT INTO " . static::TABLE . "details, date_posted, time_posted, date_edited, time_edited, public)" . 
              "VALUES (:details, :date_posted, :time_posted, :public)";
    $params = [
      'details'     => $postData['details'],
      'time_posted' => $postData['postTime'],
      'date_posted' => $postData['postDate'],
      'public'      => $postData['isPublic']
    ]

      (new SqlCommand())->write($sql, $params)->execute();
  }

  public function update($postData) 
  {
    $sql    = "UPDATE" . static::TABLE . " SET details=:details, date_edited=:date, time_edited=:time, public=:public WHERE id=:id";
    $params = [
      'id'      => $postData['id'],
      'details' => $postData['details'],
      'date'    => $postData['editDate'],
      'time'    => $postData['editTime'],
      'public'  => $postData['isPublic']
    ];

    (new SqlCommand())->write($sql, $params)->execute();
  }

  public function delete($id) 
  {
    $sql = "DELETE FROM " . static::TABLE  . " WHERE id=:id"; 
    
    (new SqlCommand())->write($sql, ['id' => $id])->execute();
  }

}

