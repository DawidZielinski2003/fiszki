<?php 
$conn = new mysqli("localhost", "root", "", "fiszki");
 if ($conn->connect_error)
 { exit("Connection failed: " . $conn->connect_error); } 
 ?> 