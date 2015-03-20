$(document).ready(function(){
	$('#create').on('click', function(){ //works when Create button is clicked
	
		//gets posted values from Registration Form
		var name=$('#name').val();
		var email=$('#email').val();
		var repeatemail=$('#remail').val();
		var password=$('#pass').val();
		var confirmpassword=$('#rpass').val();
		//creates a datastring to pass variables to php file
		var dataString='name='+name+'&email='+email+'&password='+password;
		
		if(name==''||email==''||repeatemail==''||password==''||confirmpassword==''){ //if fields are empty
			document.getElementById('successDiv2').style.display="none";
			document.getElementById('alertDiv2').style.display="";
			document.getElementById('alert2').innerHTML ="Please fill in the required fields!";	
		}else if(email!=repeatemail){ //if emails do not match
			document.getElementById('successDiv2').style.display="none";
			document.getElementById('alertDiv2').style.display="";
			document.getElementById('alert2').innerHTML ="Email and Confirm Email do not match!";		
		}else if(password.length<4){
			document.getElementById('successDiv2').style.display="none";
			document.getElementById('alertDiv2').style.display="";
			document.getElementById('alert2').innerHTML ="Password must be longer than 4 characters!";			
		}else if(password!=confirmpassword){ //if passwords do not match
			document.getElementById('successDiv2').style.display="none";
			document.getElementById('alertDiv2').style.display="";
			document.getElementById('alert2').innerHTML ="Password and Confirm Password do not match!";	
		}else{
			
			//post variables with AJAX to PHP
			$.ajax({
			type:"POST",
			url:"../peerdb/register.php",
			data: dataString,
			cache: false,
			success:function(data){ //get response from PHP(echo)
			
				if(data=="Success! You can login to your account once the Admin confirms your registration!"){ //successful Registration
					document.getElementById('alertDiv2').style.display="none";
					document.getElementById('successDiv2').style.display="";
					document.getElementById('success2').innerHTML =data;	
				}else if(data=="This email address is already registered. Please use another email address."){ //failed Registration (existing email)
					document.getElementById('successDiv2').style.display="none";
					document.getElementById('alertDiv2').style.display="";
					document.getElementById('alert2').innerHTML =data;	
				}else{ //failed Registration (DB error)
					document.getElementById('successDiv2').style.display="none";
					document.getElementById('alertDiv2').style.display="";
					document.getElementById('alert2').innerHTML =data;
				}
			
			}
			});
				
			}	
		
		return false;
				
	});	
});