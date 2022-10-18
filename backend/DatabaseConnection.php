<?php

class DatabaseConnection
{
  var $host, $dbname, $user, $password, $port, $conn;

  function __construct()
  {
    $this->$host = "ec2-54-220-86-118.eu-west-1.compute.amazonaws.com";
    $this->$dbname = "dff58ne6abfhe2";
    $this->$user = "jbwrbjykvuahhh";
    $this->$password = "7d249d82e458cb41f9ff393d72ce1b304353ad833a7effce16ae52e3bac5bbd3";
    $this->$port = "5432";
  }

  function getConnection()
  {
    $conn_string = "host=".$this->$host." port=".$this->$port." dbname=".$this->$dbname." user=".$this->$user." password=".$this->$password."";
    $con = pg_connect($conn_string) or die("Connection failed: ".pg_last_error());
    
    /* check connection */
    if (pg_last_error()) 
    {
      printf("Connection failed: %s\n", pg_last_error());
      exit();
    } 
    else 
    {
      $this->conn = $con;
    }

    return $this->conn;
  }
}






//$insert_query = "INSERT INTO prenotazioni  (id,nome_rich, cognome_rich, email_rich,oggetto_rich) VALUES (1,'$name','$surname', '$email','$testo')";
//$result = pg_query($conn, $insert_query);


/*
// Attempt create table query execution
$sql = "CREATE TABLE leaderboard(
  psp_reference VARCHAR(16) NOT NULL PRIMARY KEY,
  shopper_reference VARCHAR(30) NOT NULL,
  fraud_score VARCHAR(30) NOT NULL,
  result_code VARCHAR(70) NOT NULL
)";

$result = pg_connect($conn,$sql);
*/
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

?>