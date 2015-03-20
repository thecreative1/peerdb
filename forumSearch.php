<?php
include 'dbcon.php';
session_start();

$response = '';

if (!isset($_POST['search'])) {
	// Error
}

$search = mysqli_real_escape_string($conn, $_POST['search']);

// Fetch the thread properties
$threadSql = "SELECT * FROM thread WHERE subject LIKE '%$search%'";
$threads = mysqli_query($conn, $threadSql);

while ($thread = mysqli_fetch_array($threads)) {
	$response .= '<a href="detailTopic.php?id=' . $thread['threadID'] . '" target="_blank">' . $thread['subject'] .'</a><br>';
}

// Search the messages
$messageSql = "SELECT * FROM message WHERE text LIKE '%$search%'";
$messages = mysqli_query($conn, $messageSql);

while ($message = mysqli_fetch_array($messages)) {
	$threadSql = "SELECT * FROM thread WHERE threadID = '".$message['threadID']."'";
	$thread = mysqli_fetch_array(mysqli_query($conn, $threadSql));

	$response .= '<a href="detailTopic.php?id=' . $thread['threadID'] . '"target="_blank">';

	$response .= $thread['subject'] .': ';
	$response .= $message['text'] .'</a><br>';
}

echo $response;