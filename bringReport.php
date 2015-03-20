<?php
include 'dbcon.php';
session_start();

if(isset($_POST['selected'])){ //if a group is selected from the dropdown box
	$selectedgroup=$_POST['selected'];
	$sql="SELECT reportData FROM groups WHERE groupName='$selectedgroup'"; //get the report data of the selected group
	$result = mysqli_query($conn,$sql);
	$row=mysqli_fetch_array($result);
	
	echo $row['reportData'];
}
?>