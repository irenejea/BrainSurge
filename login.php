<!DOCTYPE html>
<html>
<head>
	<title>Log in | Brain Surge</title>
	<link rel="stylesheet" href="./login.css" type="text/css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"> </script>
	<script type = "text/javascript" src = "./login.js"></script>
</head>

<div id="head">
	<h1 id="logo"><a href="home.php"><img src="logo.png"></a></h1>
</div>
<div id="container">
<div id="login">
	<h2> Log in </h2>
	<p> Enter your username and password to log in. </p>
	<form id="formL" method="post" action="login.php">
	<ul>
	<li><input id="id" type="text" name="id" placeholder="Username" size="45"/></li>
	<li><input id="pw" type="password" name="pw" placeholder="Password" size="45"/>
		<br><span id="loginError" class="error">Invalid username and password</span></li>
	</ul>
	<p><input type="submit" id="submitL" name="login" value="Log in"/></p>
	</form>
</div>
<div id="register">
	<h2> New user? </h2>
	<p> Register below to create a profile. </p>
	<form id="formR" method="post" action="login.php">
	<p>
		<input id="fn" type="text" name="fn" placeholder="First Name" size="20"/>
		<input id="ln" type="text" name="ln" placeholder="Last Name" size="20"/>
		<span class="error">These fields are required</span>
	</p>
	<ul>
	<li><input type="text" id="user" name="user" placeholder="Username" size="45"/>
		<span class="error">A valid username is required</span></li>
	<li><input type="password" id="pass" name="pass" placeholder="Password" size="45"/>
		<span class="error">A valid password is required</span></li>
	</ul>
	<p><input type="submit" id="submitR" name="register" value="Register"/>
		<span class="taken">That</span></p>
	</form>
</div>

</div>
</html>

<?php
	if(isset($_POST["register"])){
		$first = $_POST["fn"];
		$last = $_POST["ln"];
		$un = $_POST["user"];
		$pw = $_POST["pass"];
		register($first, $last, $un, $pw);
	}
	if(isset($_POST["login"])){
		$un = $_POST["id"];
		$pw = $_POST["pw"];
		login($un, $pw);
	}

	function register($first, $last, $un, $pw){
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
		if(in_array($un, $names)){
			echo "<script type = 'text/javascript'>
				alert('That username is taken. Choose another and try again.') </script>";	
		}
		else{
			echo "<script type = 'text/javascript'>
				alert('Thanks for registering. You can now login using your username and password.') </script>";	
			$stmt = mysqli_prepare ($connect, "INSERT INTO $table VALUES (?, ?, ?, ?)");
			mysqli_stmt_bind_param ($stmt, 'ssss', $first, $last, $un, $pw);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
		mysqli_close($connect);
	}
	function login($un, $pw){
		$host = "fall-2014.cs.utexas.edu";
		$user = "irenej";
		$pwd = "Ap+sVVJQbw";
		$dbs = "cs329e_irenej";
		$port = "3306";
		$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
		$table = "brainsurge";
		
		$result = mysqli_query($connect, "SELECT * from $table where Username = \"$un\"");
		$row = $result->fetch_row();
		if(count($row) == 0){
			echo "<script type = 'text/javascript'>
				alert('That username is not registered.') </script>";	
		}
		else if($row[3] != $pw){
			echo "<script type = 'text/javascript'>
				alert('Username and password do not match.') </script>";	
		}
		else{	
			setcookie("user", $un);
			header("Location: home.php");
		}
		mysqli_close($connect);
	}
?>











