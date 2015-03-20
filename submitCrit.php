<?php
session_start();
include 'dbcon.php';

if(isset($_POST['crit1'])||isset($_POST['crit2'])||isset($_POST['crit3'])||isset($_POST['crit4'])||isset($_POST['crit5'])){ //if posted by AJAX
	
	//gets values posted by AJAX
	$criteria1=mysqli_real_escape_string($conn,$_POST['crit1']);
	$criteria2=mysqli_real_escape_string($conn,$_POST['crit2']);
	$criteria3=mysqli_real_escape_string($conn,$_POST['crit3']);
	$criteria4=mysqli_real_escape_string($conn,$_POST['crit4']);
	$criteria5=mysqli_real_escape_string($conn,$_POST['crit5']);
	
	$lastID = mysqli_real_escape_string($conn,$_SESSION['lastID']); //get user lastID
	
	$sql="TRUNCATE criteria"; // delete criteria
	$result1 = mysqli_query($conn,$sql);
	$sql2="INSERT INTO criteria (criteriaData) VALUES ('$criteria1'),('$criteria2'),('$criteria3'),('$criteria4'),('$criteria5')"; //insert criteria
	$result2 = mysqli_query($conn,$sql2);

	if($result2){
		//echo "Criteria have been submitted!";
		echo json_encode(array(
			'data' => array(
				$criteria1,
				$criteria2,
				$criteria3,
				$criteria4,
				$criteria5
			)
		));
	}else{
		echo json_encode(array());
	}
}

?>
