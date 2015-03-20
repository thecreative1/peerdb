<?php 
include 'dbcon.php'; 
session_start(); //starts session
if(isset($_SESSION['lastID'])){ //checks if a lastID is set (is a user logged in?)

$lastID = mysqli_real_escape_string($conn,$_SESSION['lastID']); //get lastID(current user)

//gets related information about the Student User
$sql1="SELECT * FROM student INNER JOIN groups ON student.groupID = groups.groupID WHERE studentID='$lastID'";
$result1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_array($result1);
$groupName=$row1['groupName'];
$studentName=$row1['studentName'];
$groupID=$row1['groupID'];
$reportData=$row1['reportData'];

// Gets other students that belong to this Group
$sql2="SELECT * FROM student WHERE groupID='$groupID'";
$result2=mysqli_query($conn,$sql2);

//gets assessment attributes for person logged in
$sql3="SELECT * FROM assessment WHERE assessment.groupID = '$groupID'";
$result3=mysqli_query($conn,$sql3);

$sql4="SELECT * FROM groups g WHERE g.groupID = '$groupID'";
$result4=mysqli_query($conn, $sql4);

?>
<!DOCTYPE html>
<!--HEAD-->
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

  <!-- Star rating -->
  <link rel="stylesheet" type="text/css" href="star-rating/jquery.rating.css">

  <script src="star-rating/jquery.form.js" type="text/javascript"></script>
  <script src="star-rating/jquery.js" type="text/javascript"></script>
  <script src="star-rating/jquery.MetaData.js" type="text/javascript"></script>
  <script src="star-rating/jquery.rating.js" type="text/javascript"></script>
  <script src="star-rating/jquery.rating.pack.js" type="text/javascript"></script>
	
  <!--JS for Changing Password-->
  <script src="js/changePass.js" type="text/javascript"></script> 

  <!--JS for Submit Assessment-->
  <script src="js/submitAssessment.js" type="text/javascript"></script> 

  <!-- JS for default operations such as selection and activating tab content -->
  <script src="js/script.js" type="text/javascript"></script> 

  <!-- Personalized style sheet to override all others-->
  <link rel="stylesheet" type="text/css" href="css/style.css">

  <meta charset="UTF-8">

</head>

<!--BODY-->
<body>
  <div id="wrapper">
		<!--Navigation Bar-->
    <div class="nav-container">
      <header id="top" class="navbar bs-docs-nav" role="banner">
       	<div class="container">
			<div class="navbar-header"></div>
		</div>

		<div class="container">
		  <div class="navbar-collapse bs-navbar-collapse collapse horizontal-line-break">
		    <!--Navigation Bar Tabs-->
		    <ul id="categories" class="nav navbar-nav "> 
				<!--ul class="nav nav-tabs"-->
				<!--Student Tab-->
			    	<?php
					//gets the Name of the User from DB
					echo "<li id='toptab' onclick='myFunction()' class='toptab studenttab' role='presentation'>
					<a class='toptabcontent' href='#'>".$studentName."</a> 
					</li>";
			    	?>
					<!--Group Profile Tab-->
				  <li id='toptab' onclick='myFunction()' class='toptab profiletab active' role='presentation'>
					<a class='toptabcontent' href='#'>Group</a>
				  </li>
					<!--Space Tab-->
				  <li id="toptab" class="toptab spacetab" onclick="myFunction()" role="presentation">
					<a class="toptabcontent" href="#">Space</a>
				  </li>
					<!--Forum Tab-->
				  <li id="toptab" class="toptab forumtab" onclick="myFunction()" role="presentation">
					<a class="toptabcontent" href="#">Forum</a>
				  </li>
				  <!-- Rank Tab -->
				  <li id="toptab" class="toptab ranktab" onclick="myFunction()" role="presentation">
					<a class="toptabcontent" href="#">Results</a>
				  </li>
			
			</ul>
			  <!--LOGOUT button -->
			  <form action="logout.php" method="post"> <!--posts to logout.php-->
			    <div align="right">
					<p> </p>
					<button id="logoutbutton" type="submit" name="logout" class="button-style btn-primary">Log Out</button>
				</div>				
			  </form>	      
          </div>	
       	</div>
      </header>
    </div>

    <div id="outer-container" class="conatainer bs-docs-masthead" role="main">
      <div id="inner-container" class="container">    
		<!--Group Profile Content-->
		  <div id="profilecontent">
		  	<div class="panel panel-default">
				<?php 
					//gets the Student's Group Name from DB
					echo "<div class='panel-heading'>";
					echo "<h3 class='panel-title'>".$groupName."</h3>"; 
					echo "</div>";
					//gets Names and Emails of all members of the Group
					echo 	"<table class='table table-striped'>
					<thead>
					<tr>
					<th>Student #</th>
					<th>Student</th>
					<th>Email</th>
					</tr>
					<tbody>";
					$count=1;
					while($row2=mysqli_fetch_array($result2)){ 
					echo "<tr><td>".$count."</td>";
					echo "<td>".$row2['studentName']."</td>";
					echo "<td>".$row2['studentEmail']."</td></tr>";
					$count++;
					}
					echo "</tbody>
					</table>";
				?>
 			</div>

			  <!--Section to Upload the Group Report-->
			  <div id="reportupload">
				<div id="uploadXML">
			      <form action="receiveXML.php" method="post" enctype="multipart/form-data">
			      	<h4>Upload Group Report</h4>
			    		Select XML report to upload:
			    	<input type="file" name="fileToUpload" id="fileToUpload">
			    	<button type="submit" value="Upload" name="submit" id="submit-xml-btn" class="btn-primary button-style">Upload Report</button>
				  </form>
			    </div><br>
			  </div>
			 
			   
			  <div class="panel panel-default">
			    <div class="alert" style="display:none" id="alert-message">
					<div id="uploadMessage"></div>
		    	</div>
			  </div>

				<script>
				// This JS allows the report.xml file to be uploaded to the website
				$(document).ready(function() { 
					var options = { 
					    target:   '#uploadResults',   
					    resetForm: true  
					}; 
				   
					$('form[action="receiveXML.php"]').submit(function(event) {
					    event.preventDefault();

					    var formData = new FormData($('form[action="receiveXML.php"]')[0]);
						$.ajax({
							url:'receiveXML.php',
							type:'POST',
							success: function(data) {
								$('#alert-message').show().addClass('alert-success').removeClass('alert-danger');
								$('#uploadMessage').html(data.message);
								$('pre#group').html(data.fileContent);
							},
							error: function(data) {
								var result = 'Error : ' + data.message;
								$('#alert-message').show().addClass('alert-danger').removeClass('alert-success');
								$('#uploadMessage').html(result);
							},
							data: formData,
							processData: false,
							contentType: false,
							dataType: 'json'
						});
					return false; 
					}); 
				});
				</script>

			<div class="panel-default">
				<?php
				$groups = mysqli_fetch_array($result4);
				?>

				<pre id="group">
				<?php echo ($groups['reportData']); ?>
				</pre>
			</div>

 		  </div>
	 			
		    <!--Group Space Content-->
		    <div id='spacecontent'>
			
						<!--Table to view allocated groups' reports and make an Assessment to them-->	
						<?php
							//gets the allocated assessments (made to other Groups)
							$sql5="SELECT receiverName FROM allocation WHERE senderName='$groupName'";
							$result5=mysqli_query($conn,$sql5);
						?>

					<form method="POST" id="assessment" action="submitAssessment">	
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Make an Assessment</h3>
							</div>
							<table class="table table-striped">
								<thead>
									<form name='showAssessment' method='post' id='showAssessment'>
										<tr>
											<td>
												<select id='select_assessment' onchange='showForm(this)' name="select_assessment">
													<option value=''>Please choose a group</option><br>
														<?php
														while($row5 = mysqli_fetch_array($result5)){
															echo "<option value='".$row5['receiverName']."'>".$row5['receiverName']."</option>";		 
														}
														?>
												</select>
											</td>
										</tr>
									</form>			
								</thead>
							</table>
						</div>

						<div class="panel-default">
							<div id="update"></div>
						</div>
								
						<!--JS code to get the requested report from database via bringReport.php-->
						<script type="text/javascript">
							$('#select_assessment').change(function(event) {
								$('#assessment-form').show();
								$.post('bringReport.php', { selected: $('#select_assessment').val() },
									function(data) {
										$('pre#space').html(data);
									}
								); 
							}); 
						</script>

						<div class="panel-default">
							<pre id="space"></pre>
						</div>

						<?php
							// Gets the allocated assessments (made to other Groups)
							$criteriaSql = "select c.* from criteria c left outer join assessment a on a.criteriaID = c.criteriaID and a.groupID = '$groupName'";
							$criteria = mysqli_query($conn, $criteriaSql);
						?>
								    
						<div id="assessment-form" class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Assess</h3>
							</div>
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Criterions</th>
										<th>Ratings</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									while($crit = mysqli_fetch_array($criteria)):
									?>
										<tr>
											<td>
												Criterion <?php echo $crit['criteriaID']; ?><br>
												<?php echo $crit['criteriaData']; ?>
					        				</td>
											<td>
					          					<span class="star-rating" onchange="showForm(this)">
					        						<input name="star[<?php echo $crit['criteriaID']; ?>]" type="radio" class="star" value="1"/>
					        						<input name="star[<?php echo $crit['criteriaID']; ?>]" type="radio" class="star" value="2"/>
					        						<input name="star[<?php echo $crit['criteriaID']; ?>]" type="radio" class="star" value="3"/>
					        						<input name="star[<?php echo $crit['criteriaID']; ?>]" type="radio" class="star" value="4"/>
					        						<input name="star[<?php echo $crit['criteriaID']; ?>]" type="radio" class="star" value="5"/>
					        		  			</span>
					        		  			<br>
					            				<textarea name="comment[<?php echo $crit['criteriaID'];?>]" required></textarea>
					        				</td>
										</tr>
									<?php 
									endwhile;
									?>
								</tbody>
							</table>
							<br>
							<button id="assessment" type="submit" class="btn-primary button-style">Submit Assessment</button> <!--Submit Assessment button-->
							<br>
					</form>
					<!--Alert-->
					<br>
					<div class="alert alert-danger" style="display:none" id="alertDiv3">
						<p id="alert3"></p>
					</div>
					<!--Success-->
					<div class="alert alert-success" style="display:none" id="successDiv3">
						<p id="success3"></p>
					</div>
			</div>
  			
		  </div>
        
		<!--Group Forum Content-->
    	<div id="forumcontent">
    		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><p><?php echo $groupName; ?> Forum<p></h3>
			</div>
			<table class="table table-striped">
				<form id="search">
				<thead>
					<tr>
						<td>
								<input type="text" name="search" />
						</td>
						<td colspan="2">
							<button id="searchbutton" type="submit" name="searchbutton" class="button-style btn-primary">Search</button>
						</td>
					</tr>
				</thead>
				</form>
			</table>
		</div>

			<div class="panel panel-default">
			<div class="panel-heading">
				<h3 id="forumSubjects" class="panel-title"><p>Forum Subjects<p></h3>
			</div>
			<table class="table table-striped">
				<thead>
					<tr>
						<td>
						</td>
					</tr>
				</thead>

			</table>
			<div id="forumThreads">
				<?php
				$threadsSql = "SELECT * FROM thread WHERE groupID = '$groupID'";
				$threads = mysqli_query($conn, $threadsSql);
				echo '<tbody>';
				while ($thread = mysqli_fetch_array($threads)):
				?>
				<tr>
					<td>
						<a href="detailTopic.php?id=<?php echo $thread['threadID']; ?>" target="_blank"><?php echo $thread['subject']; ?><br>
						</a>
					<td>
				</tr>
				<?php
				endwhile;?><br>
				<div id="forumtopics">
					<div class="alert alert-success" style="display:none">
						<p class="messsage"></p>
					</div>
				</div>
				<tr>
					<td>
						
					</td>
				</tr><?php
				echo '</tbody>';?>
			</div><br>
			<form id="createtopic" action="createTopic.php" method="POST">
					  		<input type="text" name="subject" id="subject" />
					  		<input class="button-style btn-primary" type="submit" value="Create a new topic" />
					  	</form>
		</div>
		
	  <script>
		$(document).ready(function(){
				  	// Search 
				  	$('form#search').submit(function(e){
						e.preventDefault();

						var $form = $(this);
				  		$.ajax({
				  			type:"POST",
				  			url:"../peerdb/forumSearch.php",
				  			data: $form.serialize(),
				  			success: function(data) {
				  				$('#forumThreads').html(data);
				  				$('#forumSubjects').html('Search Results');
				  			}
				  		});

				  	});

			  		$('form[action="createTopic.php"]').submit(function(e) {
			  			e.preventDefault();

			  			var $form = $(this);
			  			$.ajax({
				  			type:"POST",
				  			url: "../peerdb/createTopic.php",
				  			data: $form.serialize(),
				  			success: function(data) {
				  				$('#forumtopics .alert').show().find('p').text(data);
				  			}
				  		});
			  		});
				  });
	  </script>

		</div>
				


	  <!--Student Content-->
      <div id="studentcontent">

		  <div class="panel panel-default">
		  	<div class="panel-heading">
		  		<h3 class="panel-title">Change Password</h3>
		  	</div>
		  	<form  class="form" name="changepass" method="post">
		  		<table class="table table-striped">
		  			<thead>
		  				  <tr>
		  					<td>Current Password:</td>
		  				  </tr>
		  			</thead>
		  			<tbody>
		  				<div class="form-group">
		  				  <tr>
		  					<td>
		  						<input type="password" name="oldpass" class="form-control" id="oldpass" placeholder="Enter your current password">
		  					</td>
		  				  </tr>
		  				</div>
		  				  <tr>
		  					<td>New Password:</td>
		  				  </tr>
		  				<div class="form-group">
		  				  <tr>
		  				  	<td>
		  				  		<input type="password" name="newpass" class="form-control" id="newpass" placeholder="Enter your new password">
		  				  	</td>
		  				  </tr>
		  				</div>
		  				  <tr>
		  					<td>Confirm New Password:</td>
		  				  </tr>
		  				<div class="form-group">
		  				  <tr>
		  					<td>
		  						<input type="password" name="cnewpass" class="form-control" id="cnewpass" placeholder="Confirm your new password">
		  					</td>
		  				  </tr>
		  				  <tr>
		  				  	<td>
		  				  		<!--Alert-->
		  				  		<div class="alert alert-danger" style="display:none" id="alertDiv">
									<p id="alert"></p>
								</div>
								<!--Success-->
								<div class="alert alert-success" style="display:none" id="successDiv">
									<p id="success"></p>
								</div>
		  				  	</td>
		  				  </tr>
		  				</div>
		  			<tbody>
		  		</table>
		  		<button type="submit" name="save" id="save" class="button-style btn-primary">Save</button>
		  	</form>
		  </div>
	 </div>
	 <!--Rank Content-->
	 <div id="rankcontent">
	  	<?php	
	  		include 'rankings.php';
	  	?>
	  </div>
	</div>
  </div>
</div>
  <!--Footer Content-->
  <div id="footer"></div>

</body>

<!-- JS for submitting an assessment -->
<script>
	$(document).ready(function(){
				$('form#assessment').submit(function(e){ 
					e.preventDefault();
					$('#alertDiv3, #successDiv3').hide();

					$.ajax({
						type:"POST",
						url:"../peerdb/submitAssessment.php",
						data: $('form#assessment').serialize(),
						cache: false,
						dataType: 'json',
						success:function(data){
							if (data.error) {
								$('#alertDiv3').show().find('p').text(data.message);
							} else {
								$('#successDiv3').show().find('p').text(data.message);
							}
						},
						error: function() {
							$('#alertDiv3').show().find('p').text('Something failed.');
						}
							
					});

					return false;
							
				});	
				
			});

</script>

</html>
<?php } 
else{ //If a user is not logged in, he cannot view this page
echo "<script type='text/javascript'>
	alert('Please login first');
	url='http://localhost/project/login2.html';
	window.location.replace(url);
	</script>";
}
?>