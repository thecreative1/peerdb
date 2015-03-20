<?php 
session_start();

include 'dbcon.php';

if ($conn->connection_error) {
	die("Connection failed: " . $conn->connection_error);
}
		//$groupid = mysqli_real_escape_string($conn, $_POST['groupid']);
		$groupnumber = mysqli_real_escape_string($conn, $_POST['groupnumber']);
		$reportdata = mysqli_real_escape_string($conn, $_POST['reportdata']);
		$forumdata = mysqli_real_escape_string($conn, $_POST['forumdata']);

		for ($x=1; $x<=$groupnumber; $x++) {
		$groupnname = "Group " . $x;

		$sql = "INSERT INTO peerdb.group (groupname, reportdata, forumdata)
		VALUES ('$groupname', '$reportdata', '$forumdata')";
	}

		if ($conn->query($sql) === TRUE) {
    echo "New record created successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

		
	

?>