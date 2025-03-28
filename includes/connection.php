<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "medcare";

$conn = new mysqli($servername, $username, $password, $database);

//------------------------------------------------------------------------------------------------------------
//to check the connection if it work uncomment it and check if it succesfull when you are getting the database 
//------------------------------------------------------------------------------------------------------------

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully!";
