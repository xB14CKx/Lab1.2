<?php

try{

  $host = "localhost";
  $username = "root";
  $password = "";
  $database = "infowebdev";


  $conn = new mysqli($host, $username, $password, $database);

  if($conn->connect_error){
    die("Database connection unsuccessful". $conn->connect_error);
    return;
  }

}catch(\Exception $e){
  echo "Error: ".$e;
}

?>
