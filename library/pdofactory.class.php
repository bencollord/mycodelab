<?php

class PDOFactory {
  public static function getPDO($host, $dbName, $dbUsername, $dbPassword) 
  {
      try 
      {
          $dbConn = new PDO("mysql:host=$host;dbname=$dbName", $dbUsername, $dbPassword);
          $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch (PDOException $e) 
      {
          echo 'Whoops! An error occured!' . $e->getMessage();
      }
      return $dbConn;
  }

}
