<?php
	$q = $_GET['requete'];

	$con = mysqli_connect("mysql4.gear.host", "cvdata", "Xq2A9FVz~EU_", "cvdata", 3306);
	if (!$con) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
    	echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    	echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    	exit;
		
		/*
		die('Impossible de se connecter à la base de données.' . mysqli_error($con));
		*/
	}
	mysqli_select_db($con, "cvdata");
	$sql="SELECT * FROM empois";
	$result = mysqli_query($con, $sql);

	if ($result->num_rows > 0) {
		echo "plenty results";
	} else {
		echo "0 results";
	}
	mysqli_close($conn);
?>