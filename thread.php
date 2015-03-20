<!DOCTYPE html>
<!--HEAD-->
<html lang="en-US">
<head>
  <title>Thread</title>
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
	$queryparams= $_SERVER['QUERY_STRING'];

parse_str($queryparams, $threadQuery);
$threadID= $threadQuery['thread'];

$lastID = mysqli_real_escape_string($conn,$_SESSION['lastID']);
$sql1 = "SELECT * FROM student WHERE studentID='$lastID'";
$result = mysqli_query($conn,$sql1);
$row = mysqli_fetch_array($result);
$groupID = $row['groupID'];

$sqlFindGroupMembers = "SELECT studentID, studentName FROM student WHERE groupID='$groupID'";
$resultGroupMembers = mysqli_query($conn, $sqlFindGroupMembers);
$students = array();
if(mysqli_num_rows($resultGroupMembers)) {
    while($student = mysqli_fetch_assoc($resultGroupMembers)) {
      $students[$student['studentID']] = $student['studentName'];
    }
  }
    $sqltmp = "SELECT * FROM thread WHERE threadID='$threadID'";
    $result4 = mysqli_query($conn,$sqltmp);

    echo "<ul id='messages'>";
    while ($rowT = mysqli_fetch_array($result4, MYSQL_ASSOC)) {
      $msg = $rowT["message"];
      $sender = $rowT["studentID"];
      printf("<li>%s: %s</li>", $students[$sender], $msg);
    }
    echo "</ul>";

  echo "</ul>";
}

echo "<br><br>";

?> 

<!-- INPUT FIELD AND BUTTON TO ADD NEW MESSAGE TO THREAD -->
<h2>Add new message:</h2>
<textarea id="new-message-text"></textarea>
<button id="send-new-message">send</button>

<!-- SCRIPT TO ADD NEW MESSAGE -->
<script type="text/javascript">
$('#send-new-message').on('click', function() {
  var msgtext = $('#new-message-text').val();
  $("#messages").append('<li>' + msgtext + '</li>');
  <?php
    echo "$.post('newMessage2.php', {thread:" . $threadID . ", msg:" . msgtext . ", user:" . $_SESSION['lastID'] . "});";
  ?>
});
</script>

</body>
</html>