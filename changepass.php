<?php
session_start();
include 'dbcon.php';

if(isset($_POST['oldpassword']) && isset($_POST['newpassword']) && isset($_POST['confirmpassword'])){
	
	//gets values posted by AJAX
	$oldpassword=mysqli_real_escape_string($conn,$_POST['oldpassword']);
	$newpassword=mysqli_real_escape_string($conn,$_POST['newpassword']);
	$confirmpassword=mysqli_real_escape_string($conn,$_POST['confirmpassword']);
	
	$lastID = mysqli_real_escape_string($conn,$_SESSION['lastID']);
	$sql1 = "SELECT * FROM student WHERE studentID='$lastID'";
	$result1 = mysqli_query($conn,$sql1);
	$sql2 = "UPDATE student SET studentPassword ='$newpassword' WHERE studentID='$lastID'"; //updates the student password
	$row=mysqli_fetch_array($result1);


	if ($newpassword !== $confirmpassword) {
		echo 'The password dont match';
		exit();
	}
	
	if($oldpassword!=$row["studentPassword"]){ //checks if user entered a correct current password
		echo "Current password is wrong!";  //wrong current password
	}else{
		$result2 = mysqli_query($conn,$sql2);
		echo "You changed your password!";  //password changed and updated in DB
	}	
}

?>
