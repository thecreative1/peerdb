<?php 
session_start();

include 'dbcon.php';

if ($conn->connection_error) {
	die("Connection failed: " . $conn->connection_error);
}

if(isset($_POST['studentnumber']) && $_POST['studentnumber'] !='' &&
	isset($_POST['groupnumber']) && $_POST['groupnumber'] !=''){
		//$groupid = mysqli_real_escape_string($conn, $_POST['groupid']);
		$studentnumber = mysqli_real_escape_string($conn, $_POST['studentnumber']);
		$groupnumber = mysqli_real_escape_string($conn, $_POST['groupnumber']);
		
		$sql = 	"UPDATE peerdb.student
				SET groupID ='$groupnumber'
				WHERE
					studentID ='$studentnumber'";

		if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-success'>Group member ".$studentnumber. " has been allocated to Group " .$groupnumber. ".</div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
?>