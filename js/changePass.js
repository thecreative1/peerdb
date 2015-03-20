$(document).ready(function(){
						$('#save').on('click', function(){
							
						// Gets posted Criteria From values
						var oldpassword=$('#oldpass').val();
						var newpassword=$('#newpass').val();
						var confirmpassword=$('#cnewpass').val();
						// Creates a datastring to pass variables to PHP
						var dataString='oldpassword='+oldpassword+'&newpassword='+newpassword+'&confirmpassword='+ confirmpassword;
						
						if(oldpassword==''||newpassword==''||confirmpassword==''){ //if fields are empty
							document.getElementById('successDiv').style.display="none";
							document.getElementById('alertDiv').style.display="";
							document.getElementById('alert').innerHTML ="Please fill in the required fields!";	
						} else { // If passwords do not match
							if (confirmpassword!=newpassword) {
								document.getElementById('successDiv').style.display="none";
								document.getElementById('alertDiv').style.display="";
								document.getElementById('alert').innerHTML ="Password mismatch!";	
								} else {
									//Post values with AJAX to PHP
									$.ajax({
										type:"POST",
										url:"../peerdb/changepass.php",
										data: dataString,
										cache: false,
										success:function(data){
									
											if(data=="You changed your password!"){ 
												//successful process (password is updated)
												document.getElementById('alertDiv').style.display="none";
												document.getElementById('successDiv').style.display="";
												document.getElementById('success').innerHTML =data;	
											} else {  
												//failed process(current password is wrong)
												document.getElementById('successDiv').style.display="none";
												document.getElementById('alertDiv').style.display="";
												document.getElementById('alert').innerHTML =data;	
											}
										}
									});
								}	
							}
						return false;
						});	
					});