<?php

include 'dbcon.php';
session_start();

if (!isset($_POST['subject'])) {
	die('You must specify a subject.');
}

$lastID = mysqli_real_escape_string($conn, $_SESSION['lastID']);
$sql2="SELECT * FROM student WHERE studentID='$lastID'";
$result2=mysqli_query($conn,$sql2);
$row1=mysqli_fetch_array($result2);

$subject = mysqli_real_escape_string($conn, $_POST['subject']);
$safeGroupID = mysqli_real_escape_string($conn, $row1['groupID']);

// Inserts the newly created subjects into thread
$sql="INSERT INTO thread VALUES (null, '$subject', NOW(), '$safeGroupID')"; 
$result = mysqli_query($conn,$sql);

if ($result) {
	echo 'A new thread was created.';
} else {
	echo 'Failed.';
}