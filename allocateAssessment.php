<?php
session_start();
include 'dbcon.php';

if(isset($_POST['fromgroup'])&&isset($_POST['togroup'])){
	
	//gets values posted by AJAX
	$fromGroup=mysqli_real_escape_string($conn,$_POST['fromgroup']);
	$toGroup=mysqli_real_escape_string($conn,$_POST['togroup']);

	//inserts the assessing group and assessed groups (sender/receiver)
	$sql1="INSERT INTO allocation (receiverName, senderName) VALUES ('$toGroup', '$fromGroup')";
	$result1=mysqli_query($conn,$sql1);
	
	//checks if query runs successfully
	if($result1){
		$successmsg=$fromGroup." will assess ".$toGroup;
		echo $successmsg;
	}else{
		$errormsg="An error has occurred!";
		echo $errormsg;
	}
		
}

?>