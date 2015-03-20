<?php
// Search for names and messages
session_start();

include 'dbcon.php';

$searchQuery= mysqli_real_escape_string($conn, $_POST['searchQuery']);
$forumID= mysqli_real_escape_string($conn, $_POST['forumID']);
$groupID= mysqli_real_escape_string($conn, $_POST['groupID']);

// Find all memebers in the group, to link message senderIDs to their names
$sqlFindGroupMembers = "SELECT studentID, studentName FROM student WHERE groupID='$groupID'";
$resultGroupMembers = mysqli_query($conn, $sqlFindGroupMembers);
$students = array();
if(mysqli_num_rows($resultGroupMembers)) {
		while($student = mysqli_fetch_assoc($resultGroupMembers)) {
			$students[$student['studentID']] = $student['studentName'];
		}
	}

	//error_log("students['3']: " . $students['4']);

// Find all threads in our forum:
$sqlFindThreads = "SELECT threadID FROM forum WHERE forumID='$forumID'";

$resultThreads = mysqli_query($conn, $sqlFindThreads);
$threadIDs = array();

// Copies the threatIDs into an array to be used in another SQL query to retrieve the messages in the threads
while($row = $resultThreads->fetch_array())
  {
  	array_push($threadIDs, $row['threadID']);
  }

$tt = implode(',', $threadIDs);

$sqlMessages = "SELECT * FROM thread WHERE threadID IN ($tt) AND message LIKE '%$searchQuery%'";
$resultMessages = mysqli_query($conn, $sqlMessages);

// Search for forums with title like search query:
$sqlSearchForums = "SELECT * FROM forum WHERE forumID='$forumID' AND threadName LIKE '%$searchQuery%'";
$resultForums = mysqli_query($conn, $sqlSearchForums);


// Initialise arrays for json:
$forums = array();
$messages = array();

// Fill found threads into JSON
if(mysqli_num_rows($resultForums)) {
		while($forum = mysqli_fetch_assoc($resultForums)) {
			$forums[] = array('forum'=>$forum);
		}
	}

	if(mysqli_num_rows($resultMessages)) {
		while($msg = mysqli_fetch_assoc($resultMessages)) {
			error_log("1:::  " . $msg['studentID']);
			$messages[] = array('message'=>$msg, 'senderName'=>$students[$msg['studentID']]);
		}
	}
	// Returns JSON with found threads and messages
	header('Content-type: application/json');
	echo json_encode(array('forums'=>$forums, 'messages'=>$messages));

?>