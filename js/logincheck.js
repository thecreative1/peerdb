$(document).ready(function(){
	$('#login').on('click', function(){ //works on Login button click
		
		//gets values posted by Login form
		var email=$('#useremail').val();
		var password=$('#userpass').val();
		//creates a datastring to pass variables to php file
		var dataString='email='+email+'&password='+password;
		
		//If fields are empty
		if(email==''||password==''){
			document.getElementById('successDiv').style.display="none";
			document.getElementById('alertDiv').style.display="";
			document.getElementById('alert').innerHTML ="Please fill in the required fields!";	
		}else{
			
			//posts variables to logincheck.php
			$.ajax({
			type:"POST",
			url:"../peerdb/logincheck.php",
			data: dataString,
			cache: false,
			success:function(data){ //gets response (echo) from php
			
				if(data=="Admin Login Successful!"){ //Admin-successful Login
					document.getElementById('alertDiv').style.display="none";
					document.getElementById('successDiv').style.display="";
					document.getElementById('success').innerHTML =data;	
					window.location.href = '../peerdb/admin.php';
				}else if(data=="Student Login Successful!"){ //Student-successful Login
					document.getElementById('alertDiv').style.display="none";
					document.getElementById('successDiv').style.display="";
					document.getElementById('success').innerHTML =data;	
					window.location.href = '../peerdb/main.php';
				}else if(data=="Your password is wrong."){  //failed Login(wrong password)
					document.getElementById('successDiv').style.display="none";
					document.getElementById('alertDiv').style.display="";
					document.getElementById('alert').innerHTML =data;	
				}else if(data=="Your account is not active yet!"){ //inactive account
					document.getElementById('successDiv').style.display="none";
					document.getElementById('alertDiv').style.display="";
					document.getElementById('alert').innerHTML =data;
				}else{ //failed Login(wrong email)
					document.getElementById('successDiv').style.display="none";
					document.getElementById('alertDiv').style.display="";
					document.getElementById('alert').innerHTML =data;
				}
			}
			});
				
			}	
		
		return false;
				
	});	
});