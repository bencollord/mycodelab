<?php
session_start(); //starts the session
if ($_SESSION['user']) {
} //checks if user is logged in
else {
    header("location:index.php"); //redirects if user is not logged in
}
if ($_SERVER['REQUEST_METHOD'] == "GET") //Added and  "if" to keep the page secure.
    {
    
    include('db.inc.php');
    
    $id = $_GET['id'];
    
    $stmt = $dbConn->prepare("DELETE FROM listtbl WHERE id=:id"); //SQL query
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    header("location:home.users.html.php");
}
?>