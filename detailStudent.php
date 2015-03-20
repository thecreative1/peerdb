<?php
include 'dbcon.php';
session_start();

$studentID = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch the student properties
$studentSql = "SELECT * FROM student WHERE studentID = '$studentID'";
$student = mysqli_fetch_array(mysqli_query($conn, $studentSql));

?>
<!DOCTYPE html
<html lang="en-US">
	<head>
	  <title>LoginPage</title>
	  <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	  <link rel="stylesheet" type="text/css" href="css/docs.min.css">
	  <link rel="stylesheet" type="text/css" href="css/formlar.css">
	 
	  <script src="js/gen_validatorv4.js" type="text/javascript"></script>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

	  <script src="//use.edgefonts.net/mr-bedfort;bubbler-one;english-small-caps;nova-cut.js"></script>

	  <!-- JS for default operations such as selection and activating tab content -->
	  <script src="js/script.js" type="text/javascript"></script> 

	  <!-- Personalized style sheet to override all others-->
	  <link rel="stylesheet" type="text/css" href="css/style.css">

	  <meta charset="UTF-8">
	</head>
	<body>
		
	<div class="nav-container">
      <header id="top" class="navbar bs-docs-nav" role="banner">
		<div class="container" style="height: 60px">
			<div class="navbar-collapse bs-navbar-collapse collapse horizontal-line-break">
				<div class="navbar-header"></div>
					<div align="right">
						<p> </p>
						<form action="logout.php" method="post">
						<button id="logoutbutton" type="submit" name="logout" class="button-style btn-primary">Log Out</button>
						 </form>	 
					</div>		
				</div>
			  <!--LOGOUT button -->
			   <!--posts to logout.php-->			      
        </div>	  
      </header>
     </div>
    </div>
	<div id="outer-container" class="conatainer bs-docs-masthead" role="main">
      <div id="inner-container" class="container">
	    <span>
	    	<div class="panel panel-default">
	    		<div class="panel-body">
	    			<table class="table" style="font-size: 14px;">
	    				<tbody>
							<tr>
								<td style="border-top: none;">Student ID</td>
								<td style="border-top: none;" class="studentid"><?php echo $student['studentID']; ?></td>
							</tr>
							<tr>
								<td>Name</td>
								<td class="studentname"><?php echo $student['studentName']; ?></td>
							</tr>
							<tr>
								<td>Email</td>
								<td class="studentemail"><?php echo $student['studentEmail']; ?></td>
							</tr>
							<tr>
								<td>Group Name</td>
								<td class="studentgroup">Group <?php echo $student['groupID']; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</span>
	  </div>
	</div>

	<!--Footer Content-->
  	<div id="footer"></div>

	</body>
</html>