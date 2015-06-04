<?php
    session_start();
    include('db.inc.php');
    if($_SESSION['user']) {}
    else {
        header("location:index.php");
    }
    if($_SERVER['REQUEST_METHOD'] == "POST") //Added and  "if" to keep the page secure.
    {
        $details = $_POST['details']; //details is what the user enters.
        $time = strftime("%X"); //time
        $date = strftime("%Y %B %d"); //date
        $decision = "no";
    
    foreach($_POST['public'] as $each_check) //get the data from the checkbox
    {
        if($each_check !=null) { //checks if checkbox is checked
            $decision = "yes"; //sets value
        }
    }
        
        $stmt = $dbConn->prepare("INSERT INTO listtbl (details, date_posted, time_posted, public) VALUES (:details, :date, :time, :decision)"); //SQL query
        $stmt->bindValue(':details', $details);
        $stmt->bindValue(':time', $time);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':decision', $decision);
        $stmt->execute();
        
        header("location:home.users.html.php");
    
    }
    else{
        header("location:home.users.html.php"); //redirects back to home.users.html.php
    }
?>