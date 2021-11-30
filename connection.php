<?php
$servername = "localhost";
$username = "root";
$password = "";
$dataBase = "mini";

// Create connection
$conn = new mysqli($servername, $username, $password,$dataBase);
try {
  $connection = new PDO("mysql:host=$servername;dbname=$dataBase", $username, $password);
  // set the PDO error mode to exception
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Database connection failed: " . $e->getMessage();
}

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?> 