<?php
include 'dbcon.php';
session_start();

$response = array(
	'message' => '',
	'error' => false
);

if (!isset($_POST['comment']) || !isset($_POST['star']) || !isset($_POST['select_assessment']) || $_POST['select_assessment'] == '') {
	$response['message'] = 'You must provide all comments and ratings.';
	$response['error'] = true;
}

if (count($_POST['comment']) < 5 || count($_POST['star']) < 5) {
	$response['message'] = 'You must provide all comments and ratings.';
	$response['error'] = true;
}

if ($response['error'] === false) {
	$comments = $_POST['comment'];
	$stars    = $_POST['star'];
	// gets values posted by AJAX	
	//$comment=mysqli_real_escape_string($conn,$_POST['comment']);
	//$grade=mysqli_real_escape_string($conn,$_POST['grade']);
	$selectedgroup = $_POST['select_assessment']; //get receiver of this assessment
		
	$lastID = mysqli_real_escape_string($conn,$_SESSION['lastID']);
	$sql1 = "SELECT * FROM groups INNER JOIN student ON student.groupID = groups.groupID WHERE studentID='$lastID'"; //who clicked submit? get the info of that student
	$result1 = mysqli_query($conn,$sql1);
	$row1=mysqli_fetch_array($result1);
	$fromGroup=$row1['groupName']; //get the submitter's group

	$sql2="SELECT * FROM groups WHERE groupName='$selectedgroup'";
	$result2=mysqli_query($conn,$sql2);
	$row2=mysqli_fetch_array($result2);
	$groupID=$row2['groupID']; //get the receiver group's ID
	$success = true;

	foreach ($comments as $key => $comment) {
		$comment = mysqli_real_escape_string($conn, $comment);
		$grade   = mysqli_real_escape_string($conn, $_POST['star'][$key]);

		//Inserts the assessment to the db
		// $sql3 = "INSERT INTO assessment (groupID, commentData, grade, fromGroup, criteriaID) VALUES ('$groupID', '$commentData', '$grade', '$fromGroup', $key) ON DUPLICATE KEY UPDATE groupID=VALUES(groupID), commentData=VALUES(commentData), grade=VALUES(grade), fromGroup=VALUES(fromGroup), criteriaID=VALUES(criteriaID)";

		$sql3 = "REPLACE into assessment (groupID, commentData, grade, fromGroup, criteriaID) values('$groupID','$comment','$grade','$fromGroup','$key')";

		$result3 = mysqli_query($conn,$sql3) or die(mysqli_error($conn));

		if (!$result3) {
			$success = false;
		}
		
	}

	if ($success) {
		//successful insertion to the database
		$response['message'] = 'Your assessment is successfully submitted!';
	}else{
		//failed insertion to the database
		$response['message'] = 'A problem occurred with your assessment submission!';
		$response['error'] = true;
	}
}

echo json_encode($response);

?>
