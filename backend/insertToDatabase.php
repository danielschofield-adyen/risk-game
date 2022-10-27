<?php
//include 'DatabaseConnection.php';

/*
$db = new DatabaseConnection();
$conn = $db->getConnection();

$insert_query = "INSERT INTO leaderboard VALUES ('FK6FFTLC675ZGN82','ooo_test','70','Approved')";
$result = pg_query($conn,$insert_query);
*/
$rawData = json_decode(file_get_contents('php://input'), true);

$pspReference = $rawData['pspReference'];
$shopperReference = $rawData['shopperReference'];
$fraudScore = $rawData['fraudScore'];
$resultCode = $rawData['resultCode'];

$host       = "ec2-54-220-86-118.eu-west-1.compute.amazonaws.com";
$dbname     = "dff58ne6abfhe2";
$user       = "jbwrbjykvuahhh";
$password   = "7d249d82e458cb41f9ff393d72ce1b304353ad833a7effce16ae52e3bac5bbd3";
$port       = "5432";

$conn_string = "host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$password."";
$db = pg_connect($conn_string);

if(!$db) {
   echo "Error : Unable to open database\n";
} else {
   echo "Opened database successfully\n";
   $insert_query = "INSERT INTO leaderboard (\"psp_reference\",\"shopper_reference\",\"fraud_score\",\"result_code\") VALUES ('$pspReference','$shopperReference','$fraudScore','$resultCode')";
    $result = pg_query($db,$insert_query);
    return $result;
}

/*
if($conn){
    echo "Connected <br />".$conn;
    // Attempt create table query execution
    $sql = "CREATE TABLE leaderboard(
      psp_reference VARCHAR(16) NOT NULL PRIMARY KEY,
      shopper_reference VARCHAR(30) NOT NULL,
      fraud_score VARCHAR(30) NOT NULL,
      result_code VARCHAR(70) NOT NULL
    )";
        
    $result = pg_connect($conn,$sql);
    
  }else {
    echo "Not connected";
  }
  */

?>