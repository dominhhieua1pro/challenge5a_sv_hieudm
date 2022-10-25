<?php
  $servername = "localhost";
  $username = "root";
  $password = "123456";
  $database = "sv_hieudm_VCSprog05";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $database);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
?>