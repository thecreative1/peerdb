<?php
session_start();
include 'dbcon.php';

if(isset($_POST['selection'])&&isset($_POST['student'])){
	
	//gets values posted by AJAX
	$selectedGroup=mysqli_real_escape_string($conn,$_POST['selection']);
	$student=mysqli_real_escape_string($conn,$_POST['student']);

	//gets the selected group's groupID
	$sql1="SELECT groupID FROM groups WHERE groupName='$selectedGroup'";
	$result1=mysqli_query($conn,$sql1);
	$row1=mysqli_fetch_array($result1);
	$groupID=$row1['groupID'];
	
	//updates the student table for the selected student, using the assigned group's ID
	$sql2 = "UPDATE student SET groupID ='$groupID' WHERE studentName='$student'"; //updates the student group
	$result2=mysqli_query($conn,$sql2);
	
	//updates the isActive value of student, which activates the student account
	$sql3 = "UPDATE student SET isActive ='1' WHERE studentName='$student'";
	$result3=mysqli_query($conn,$sql3);
	
	//checks if query runs successfully
	if($result2){
		$successmsg=$student." is allocated to ".$selectedGroup;
		echo $successmsg;
	}else{
		$errormsg="An error has occurred!";
		echo $errormsg;
	}
		
}

?>
