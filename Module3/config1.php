<?php
	$conn = new mysqli("localhost","root","","addcart");
	if($conn->connect_error){
		die("Connection Failed!".$conn->connect_error);
	}
?>
