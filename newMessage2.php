<?php
//posting new message in the forum

session_start();

include 'dbcon.php';

// GET THE PARAMETERS FROM THE REQUEST
$threadID= mysqli_real_escape_string($conn, $_POST['thread']);
$msg= mysqli_real_escape_string($conn, $_POST['msg']);
$userID= mysqli_real_escape_string($conn, $_POST['user']);

// CREATE THE TIMESTAMP FOR THE NEWLY ADDED MESSAGE AS THE CURRENT TIME AND DATE:
$now = new DateTime();
$date = $now->getTimestamp();

// SQL QUERY TO INSERT THE NEW MESAGE TO THE DATABASE:
$sql = "INSERT INTO `peerdb`.`thread` (`threadID`, `message`, `dateTime`, `studentID`) VALUES ($threadID, '$msg', $date, $userID);";

// IF THE MESSAGE WAS ADDED SUCCEFULLY TO THE DATABASE RETURN GOOD, OTHERWISE ERROR:
if(mysqli_query($conn, $sql)){
		echo "good";
	}
	else{
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
	}
?>


