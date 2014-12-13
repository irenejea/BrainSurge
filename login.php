<!DOCTYPE html>
<html>
<head>
	<title>Log in | Brain Surge</title>
	<link rel="stylesheet" href="./login.css" type="text/css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"> </script>
	<script type = "text/javascript" src = "./login.js"></script>
	<script type = "text/javascript">
		function check(name){
			var xhr;
			if (window.XMLHttpRequest){
				xhr = new XMLHttpRequest();
			}
			else{
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4 && xhr.status == 200){
					var response = xhr.responseText;
					var input = $("#user");
					var elmnt = $("#taken");
					if(response == "taken"){
						input.removeClass("valid").addClass("invalid");
						elmnt.html(name + " is unavailable.");
					}
					else{
						input.removeClass("invalid").addClass("valid");
						elmnt.html("");
						if(name.length == 0){
							input.removeClass("valid").addClass("invalid");
						}
					}
				}
			}
			xhr.open("GET", "check_name.php?name=" + name, true);
			xhr.send();
		}
	</script>

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
		<input id="fn" type="text" name="fn" placeholder="*First Name" size="20"/>
		<input id="ln" type="text" name="ln" placeholder="*Last Name" size="20"/>
	</p>
	<ul>
	<li><input type="text" id="user" name="user" placeholder="*Username" size="45" onblur="check(this.value)"/>
		<span id="taken" style="color: red; font-size: small; margin-left:.5em"></span></li>
	<li><input type="password" id="pass" name="pass" placeholder="*Password" size="45"/>
		<br><span id="regError" class="error">All fields with (*) are required</span></li>
	</ul>
	<p><input type="submit" id="submitR" name="register" value="Register"/></p>
</div>

</div>
</html>

<?php
	if(isset($_POST["register"])){
		$first = purge($_POST["fn"]);
		$last = purge($_POST["ln"]);
		$un = purge($_POST["user"]);
		$pw = purge($_POST["pass"]);
		$pw_protected = crypt($pw,$un);
		register($first, $last, $un, $pw_protected);
	}
	if(isset($_POST["login"])){
		$un = purge($_POST["id"]);
		$pw = purge($_POST["pw"]);
		$pw_protected = crypt($pw,$un);
		login($un, $pw_protected);
	}

	//Dr. Mitra's basic purge function
	function purge ($str){
    		$purged_str = preg_replace("/\W/", "", $str);
    		return $purged_str;
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
			$first=mysqli_real_escape_string($connect, $first);
			$last=mysqli_real_escape_string($connect, $last);
			$un=mysqli_real_escape_string($connect, $un);
			$pw=mysqli_real_escape_string($connect, $pw);
			
			$stmt1 = mysqli_prepare ($connect, "INSERT INTO $table VALUES (?, ?, ?, ?)");
			mysqli_stmt_bind_param ($stmt1, 'ssss', $first, $last, $un, $pw);
			mysqli_stmt_execute($stmt1);
			mysqli_stmt_close($stmt1);

		$host1 = "fall-2014.cs.utexas.edu";
		$user1 = "evanaj12";
		$pwd1 = "_zqAskkb9~";
		$dbs1 = "cs329e_evanaj12";
		$port1 = "3306";
		$connect1 = mysqli_connect ($host1, $user1, $pwd1, $dbs1, $port1);

		$stmt2="INSERT INTO brainsurge_data (user) VALUES ('$un')";
        	$connect1->query($stmt2);
		mysqli_close($connect1);

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

		$un=mysqli_real_escape_string($connect, $un);
		$pw=mysqli_real_escape_string($connect, $pw);
		
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
			$name = $row[0];

                        setcookie("user", $un);
                        setcookie("first", $name);

			header("Location: home.php");
		}
		mysqli_close($connect);
	}
?>
