<?php
$servername="localhost";
$username="teamturkey";
$password="1234";
$dbname="peerdb";
//create connection
$conn=new mysqli($servername,$username,$password,$dbname);
//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>