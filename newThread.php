<?php
//posting the new thread into the forum
// VERY SIMILAR TO NEWMESSAGE2.PHP, SEE THAT FOR COMMENTS...
session_start();

include 'dbcon.php';


$forumID= mysqli_real_escape_string($conn, $_POST['forum']);
$threadName= mysqli_real_escape_string($conn, $_POST['tname']);

$sql = "INSERT INTO `peerdb`.`forum` (`forumID`, `threadID`, `threadName`) VALUES ($forumID, NULL, '$threadName');";

if(mysqli_query($conn, $sql)){
		echo "good";
} else{
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
?>


