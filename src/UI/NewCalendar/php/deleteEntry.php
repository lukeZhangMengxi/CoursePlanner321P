<?php
	// parameters set up
	$serverName = 'localhost';//'courseplanner.cs9msqhnvnqr.us-west-2.rds.amazonaws.com';
	$userName = 'root';//'courseplanner';
	$password = '';//'cpen3210';
	$databaseName = 'courseplanner';
	$table = "Unique Calendar Entry";

	//Get parameters from url
	$entryID = $_POST['id'];

	// get user ID
	//require('../session.php');
	//$session = Session::getInstance();
	$uid = 57;//$session->userID;


	// **************************************************
	//
	//		Database connecting
	//
	// **************************************************

	// Create connection
	$conn = new mysqli($serverName, $userName, $password, $databaseName);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	echo "Connected successfully \n";

	
	
	// **************************************************
	//
	//		upload information of the tile
	//
	// **************************************************
	
	$sql = "DELETE FROM `$table` WHERE `ID`=$entryID";
	if ($conn->query($sql) === TRUE) {
	    echo "Record deleted successfully \n";
	} else {
	    echo "Error deleting record: " . $conn->error;
	}
	$conn->close();
	
?>







