<?php
session_start();
include 'dbcon.php'; //database connection

if(isset($_POST['name'])&&isset($_POST['email'])&&isset($_POST['password'])){
	
//variables that are posted by AJAX
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$pass = mysqli_real_escape_string($conn, $_POST['password']);
$isActive = "false"; //default value 
$sql = "INSERT INTO student (studentName, studentPassword,studentEmail,isActive) VALUES ('$name', '$pass','$email','$isActive')"; //insert a new Student to the DB

//checks if the entered email already exists. Two different users cannot have the same email!
function emailCheck()
{
	include 'dbcon.php';
	$check=false;
	$sql1 = "SELECT studentEmail FROM student";
	$result = mysqli_query($conn,$sql1);
	$email = mysqli_real_escape_string($conn, $_POST['email']); //gets AJAX post
	while ($row=mysqli_fetch_array($result))
	{
		if($email==$row["studentEmail"]) 
		{	
			$check=true; //already registered
		}	
	}
	return $check;
}

if(emailCheck()==FALSE){ //if this is a new user
	if(mysqli_query($conn, $sql)){ //if the INSERTION query runs successfully
		echo "Success! You can login to your account once the Admin confirms your registration!"; //successful Registration
		$_SESSION['lastID'] = mysqli_insert_id($conn);
	}
	else{ //if the INSERTION query fails to run successfully
		echo "ERROR: A problem occured during your registration!"; //failed Registration (DB error)
	}
}else{ //already registered, not a new user
	echo "This email address is already registered. Please use another email address."; //failed Registration (existing user)	
}
}
?>
