<!DOCTYPE html>
<!--HEAD-->
<html lang="en-US">
<head>
  <title>Space</title>
  <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">  
  <meta charset="UTF-8">
  <script type="text/javascript" src="jquery-1.11.2.min.js"></script>
</head>
<!--BODY-->
<body>

<?php include 'dbcon.php'; 
session_start();
if(isset($_SESSION['lastID']))
{
$lastID = mysqli_real_escape_string($conn,$_SESSION['lastID']);
$sql1 = "SELECT * FROM student WHERE studentID='$lastID'";
$result = mysqli_query($conn,$sql1);
  $row = mysqli_fetch_array($result);
  $groupID = $row['groupID'];

  // Get report data:
  $sql2 = "SELECT reportData FROM groups WHERE groupID='$groupID'";
  $result2 = mysqli_query($conn,$sql2);
  $row2 = mysqli_fetch_array($result2);
  $reportData = $row2['reportData'];

echo "Your groups report: <br> $reportData";

}
?> 

</body>
</html>