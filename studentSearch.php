<?php
include 'dbcon.php';
session_start();

$response = '';

if (!isset($_POST['search'])) {
	// Error
}

$search = mysqli_real_escape_string($conn, $_POST['search']);

// Student name search
$studentSql = "SELECT * FROM student WHERE studentName LIKE '%$search%'";
$students = mysqli_query($conn, $studentSql);

// Student email search
while ($student = mysqli_fetch_array($students)) {
	$response .= '<tr>'; 
	$response .= '<td>' . $student['studentID'] .'</td>';
	$response .= '<td><a href="detailStudent.php?id=' . $student['studentID'] . '"target="_blank">';
	$response .= $student['studentName'] .'</a></td>';
	$response .= '<td>' . $student['studentEmail'] .'</td>';
	$response .= '</tr>'; 
}

echo $response;