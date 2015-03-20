$(document).ready(function(){
	$('#allocateassessment').on('click', function(){  //works when Submit button is clicked to allocate assessment
		
		//gets posted values
		var fromgroup=$("#fromgroup").val();
		var togroup=$("#togroup").val();
		
		//creates a datastring to pass variables to PHP
		var dataString='fromgroup='+fromgroup+'&togroup='+togroup;
	
		//Post values with AJAX to PHP
		$.ajax({
			type:"POST",
			url:"../peerdb/allocateAssessment.php",
			data: dataString,
			cache: false,
			success:function(data){
				if(data=="$successmsg"){  //assessment allocation successful
					document.getElementById('alertDiv2').style.display="none";
					document.getElementById('successDiv2').style.display="";
					document.getElementById('success2').innerHTML =data;		
				}else{
					document.getElementById('alertDiv2').style.display="none"; //failed allocation
					document.getElementById('successDiv2').style.display="";
					document.getElementById('success2').innerHTML =data;		
				}
			}
			});

		return false;
				
	});	
	
});