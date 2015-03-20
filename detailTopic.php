<?php
include 'dbcon.php';
session_start();

$threadID = mysqli_real_escape_string($conn, $_GET['id']);

if (isset($_POST['message'])) {
	// When we post a new message
	$lastID = mysqli_real_escape_string($conn, $_SESSION['lastID']);
	$newMessage = mysqli_real_escape_string($conn, $_POST['message']);

	$messagesSql = "INSERT INTO message VALUES (null, '$newMessage', '$lastID', CURRENT_TIMESTAMP, '$threadID')";
	$messages = mysqli_query($conn, $messagesSql);
}

// Fetch the thread properties
$threadSql = "SELECT * FROM thread WHERE threadID = '$threadID'";
$thread = mysqli_fetch_array(mysqli_query($conn, $threadSql));

// Fetch the list of messages
$messagesSql = "SELECT * FROM message WHERE threadID = '$threadID'";
$messages = mysqli_query($conn, $messagesSql);
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
	    <div style="display: block;">
	    	<div class="panel panel-default">
	    		<div class="panel-heading">
	    			<h4>Subject: <?php echo $thread['subject']; ?></h4>
	    		</div>
	    		
	    			<table class="table table-striped" style="font-size: 14px;">
	    				<thead>
	    					<tr>
	    						<td>Message</td>
	    						<td>Member</td>
	    						<td>Time</td>
	    					</tr>
	    				</thead>
	    				<tbody>
							<?php
							while ($message = mysqli_fetch_array($messages)):
								$authorID = $message['studentID'];
								$authorSql = "SELECT * FROM student WHERE studentID = '$authorID'";
								$author = mysqli_fetch_array(mysqli_query($conn, $authorSql));
							?>
								<tr>
									<td class="message"><?php echo $message['text']; ?></td>
									<td class="author"><?php echo $author['studentName']; ?></td>
									<td class="date"><?php echo $message['messageTime']; ?></td>
								</tr>
							<?php
							endwhile;
							?>
						</tbody>
					</table>
				
			</div>

		</div>
		<form method="POST">
			<textarea name="message"></textarea>
			<input type="submit" class="button-style btn-primary" style="vertical-align: top;" value="Send" />
		</form>
	  </div>
	</div>

	<!--Footer Content-->
  	<div id="footer"></div>

	</body>
</html>