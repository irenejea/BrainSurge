<?php
	$name = $_REQUEST["name"];
	
	$host = "fall-2014.cs.utexas.edu";
	$user = "irenej";
	$pwd = "Ap+sVVJQbw";
	$dbs = "cs329e_irenej";
	$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
	$table = "brainsurge";
	
	$names = array();
	$result = mysqli_query($connect, "SELECT * from $table");
	
	while ($row = $result->fetch_row()){
		array_push($names, $row[2]);
	}	
	if(in_array($name, $names)){
		echo "taken";	
	}
	mysqli_close($connect);

exit;
?>
