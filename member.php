<?php
session_start();

// We are logged in
if(isset($_SESSION['username']) && isset($_SESSION['loggedIn'])) {
	if($_SESSION['loggedIn'] == 'yes') {
		echo 'Welcome to the members area.';

		// Grab the user's row from the db
  		$mysqliobj = mysqli_connect("localhost", "root", "root", "Authentication");
  		$sqlquery = "SELECT * FROM Users WHERE Username = '".$_SESSION['username']."'";
    	$result = mysqli_query($mysqliobj, $sqlquery);
    	
    	$memberData = mysqli_fetch_assoc($result);

		// Start printing out data 
		echo "<br><br>No. User: ".$memberData['ID']."<br>Username: ".$memberData['Username']."<br>Email: ".$memberData['Email']. "<br>Date Registered: ".$memberData['DateRegistered'];
	} else {
		nonMemberExit();
	}
} else {
	nonMemberExit();
}

function nonMemberExit() {
	echo 'You must log in to access this area.';
	sleep(3);
	header('index.php');
}
?>