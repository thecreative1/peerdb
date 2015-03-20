<?php
session_start();
include 'dbcon.php'; //database connection

if(isset($_POST['email'])&&isset($_POST['password'])){
	
//searches the Student table for a matching email
function studentEmailCheck()
{
	include 'dbcon.php';
	$check=false;
	$sql1 = "SELECT studentEmail FROM student";
	$result1 = mysqli_query($conn,$sql1);
	$varemail=mysqli_real_escape_string($conn, $_POST['email']); //gets the AJAX POST(email)
	while ($row=mysqli_fetch_array($result1))
	{
		if($varemail==$row["studentEmail"])  //posted email address exists in the Student table?
		{$check=true;} //student email found
	}
	return $check;
}

//searches the Admin table for a matching email
function adminEmailCheck(){
	include 'dbcon.php';
	$sql2 = "SELECT adminEmail FROM admin";
	$result2 = mysqli_query($conn,$sql2);
	$check=false;
	$varemail=mysqli_real_escape_string($conn, $_POST['email']); //gets the AJAX POST(email)

	while ($row=mysqli_fetch_array($result2))
	{
		if($varemail==$row["adminEmail"])  //posted email address exists in the Admin table?
		{$check=true;} //admin email found
	}
	return $check;	
}

//compares the database password to the posted password for Admin Email
function adminPasswordCheck(){ 
	include 'dbcon.php';
	
    $varemail=mysqli_real_escape_string($conn, $_POST['email']); //gets the AJAX POST(email)
	$sql3 = "SELECT adminPassword FROM admin WHERE adminEmail='$varemail'";
	$result3 = mysqli_query($conn,$sql3);
	$check=false;
	$userpass=mysqli_real_escape_string($conn, $_POST['password']); //gets the AJAX POST(password)
	while ($row=mysqli_fetch_array($result3))
	{
		if($userpass==$row["adminPassword"])
		{$check=true;} //password is correct
	}
	return $check;		
}

//compares the database password to the posted password for Student Email
function studentPasswordCheck() 
{
	include 'dbcon.php';
	$varemail=mysqli_real_escape_string($conn, $_POST['email']); //gets the AJAX POST(email)
	$sql4 = "SELECT studentPassword FROM student WHERE studentEmail='$varemail'";
	$result4 = mysqli_query($conn,$sql4);
	$check=false;
	$userpass=mysqli_real_escape_string($conn, $_POST['password']); //gets the AJAX POST(password)
	while ($row=mysqli_fetch_array($result4))
	{
		if($userpass==$row["studentPassword"])
		{$check=true;} //password is correct
	}
	return $check;
}

//checks the activation status of the Student
function activationCheck(){
	include 'dbcon.php';
	$varemail=mysqli_real_escape_string($conn, $_POST['email']); //gets the AJAX POST(email)
	$sql5 = "SELECT * FROM student WHERE studentEmail='$varemail'";
	$result5 = mysqli_query($conn,$sql5);
	$check=false;
	while ($row=mysqli_fetch_array($result5))
	{
		if($row["isActive"]=='1')
		{
			$_SESSION['lastID'] = $row['studentID']; //save the ID to be able to track the user		
			echo "Student Login Successful!";
			$check=true;
		}else{
			$check=false;
			echo "Your account is not active yet!";
		}
	
	}
	return $check;	
}

if(studentEmailCheck()==TRUE||adminEmailCheck()==TRUE){ //if the email exists for a Student or Admin
	if(studentPasswordCheck()==TRUE){ //if this is a Student and his password is correct
		activationCheck();
	}else if(adminPasswordCheck()==TRUE){ //if this is the Admin and his password is correct
		$varemail=mysqli_real_escape_string($conn, $_POST['email']);
		$sql = "SELECT adminID FROM admin WHERE adminEmail='$varemail'";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($result);
		$_SESSION['lastID'] = $row['adminID']; //save the ID to be able to track the user		
		echo "Admin Login Successful!";	//successful Login
	}else{ //password is wrong
		echo "Your password is wrong."; //failed Login
	}	
}else{ //user is not registered (email does not exist)
	echo "This email address is not registered.";	//failed Login
}
}

?>
