<?php
	$conn = new mysqli('localhost', 'root', '', 'library') or die(mysqli_error());
	if(!$conn){
		die("Fatal Error: Connection Failed!");
	}