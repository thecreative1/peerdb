<?php
//ends the session and logs out the user (navigates back to Login.html-Home Page)
session_start();
session_unset(); 
session_destroy(); 
echo "<script type='text/javascript'>  
	url='../peerdb/login.html';
	window.location.replace(url);
	</script>";
?>