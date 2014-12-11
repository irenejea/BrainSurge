<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<link rel="stylesheet" href="./outline.css" type="text/css" name="style1">
</head>

<div id="container">

	<a href="./home.php"><img src="./logo.png" id="logo"></a>

<div id="title">
	<h1>Profile</h1>
</div>


<div id="info">
	<center><div id="info_title">Brain Surge Site Navigation</div></center>
	<h4><i>Personality Quizzes</i></h4>
	<ul><li><a href="./mb.php">MBTI</a></li>
	    <li><a href="./big5.php">The Big Five</a></li>
	    <li><a href="./typeAB.php">Type A/B</a></li>
	</ul>
	<h4 style="color: gray"><i>Your Profile</i></h4>
	<h4><i>More Information</h4></i>
	<dl><dt>Personality Theory</dt>
		<dd><a href="https://en.wikipedia.org/wiki/Personality_psychology">Personality Psychology</a></dd>
		<dd><a href="http://drdianehamilton.wordpress.com/2011/12/18/top-18-personality-theorists-including-freud-and-more/">Famous Personality Psychologists</a></dd>
	<br>
	    <dt>Social Psychology</dt>
		<dd><a href="https://en.wikipedia.org/wiki/Social_psychology">Social Psychology</a></dd>
		<dd><a href="http://www.ippanetwork.org/">Positive Psychology</a></dd>
	<br>
	    <dt>Neuropsychology</dt>
		<dd><a href="https://en.wikipedia.org/wiki/Neuropsychology">Neuropsychology</a></dd>
		<dd><a href="http://www.neuroaustin.com/">Local Neuropsychologists</a></dd>
	<br>
	    <dt>Other Fields of Psychology</dt>
		<dd><a href="https://en.wikipedia.org/wiki/Cognitive_psychology">Cognitive Psychology</a></dd>
		<dd><a href="https://en.wikipedia.org/wiki/Developmental_psychology">Developmental Psychology</a></dd>
		<dd><a href="https://en.wikipedia.org/wiki/Clinical_psychology">Clinical Psychology</a></dd>
		<dd><a href="https://en.wikipedia.org/wiki/Abnormal_psychology">Abnormal Psychology</a></dd>
	</dl>
	
	<h4><i>Contact Brain Surge</i></h4>
		<p><a href="./info.php">About Brain Surge and the developers</a></p>
</div>
<?php 
	if(!isset($_COOKIE["user"])){
		print <<<LOGIN
			<div id="login">
				<form method="post" action="home.php">
				<b>Login Here!</b>
				<table id="loginTable">
				<tr><td>Username:</td><td><input type="text" name="username" id="id" size="15"></td></tr>
				<tr><td>Password:</td><td><input type="password" name="password" id="pw" size="15"></td></tr>
				</table>
				<input class="btn" type="submit" value="Login" name="login" id="submitL">
				<br>
				<br>New User? Register <a href="login.php"><u>Here</u></a>
				</form>
			</div>
LOGIN;
	}
	else{	
		print <<<WELCOME
			<div id="welcome">
				Welcome back, <a href="profile.php"><u><b>{$_COOKIE["first"]}</b></u></a>
				<form method="post" action="home.php"><input type="submit" id="logout" name="logout" value="Log Out"></form>
			</div>
WELCOME;
	}	
	if(isset($_POST["logout"])){
		setcookie("first", "", time() - 3600);
		setcookie("user", "", time() - 3600);
		header("Location: home.php");
	}
	if(isset($_POST["login"])){
		if(!empty($_POST["username"]) && !empty($_POST["password"])){
                $un = purge($_POST["username"]);
                $pw = purge($_POST["password"]);
                $pw_protected = crypt($pw,$un);
                login($un, $pw_protected);
                }
                else{
                        echo "<script type = 'text/javascript'>
                                alert('Please fill in both fields to login.') </script>";
                }
        }
        //Dr. Mitra's basic purge function
        function purge ($str){
                $purged_str = preg_replace("/\W/", "", $str);
                return $purged_str;
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
			setcookie("first", $name);
			setcookie("user", $un);
			header("Location: home.php");
		}
		mysqli_close($connect);
	}
?>

<div id="main">


<?php

function view_all(){

	$host = "fall-2014.cs.utexas.edu";
	$user = "evanaj12";
        $pwd = "_zqAskkb9~";
        $dbs = "cs329e_evanaj12";
	$port = "3306";
	$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);
	$table = "brainsurge_data";

        if (empty($connect))
        {
                die("mysqli_connect failed: " . mysqli_connect_error());
                return;
        }

        //print "Connected to ". mysqli_get_host_info($connect) . "<br><hr><br>\n";

// Get data from a table in the database and print it out
	$un = $_COOKIE["user"];
	$name = $_COOKIE["first"];

        $result_mb = mysqli_query($connect, "SELECT (mbti) from $table WHERE user = '$un'");
	$mb_res = $result_mb->fetch_row();
	$mb_strs = explode(":",$mb_res[0]);

	$type=$mb_strs[0];
	$e=strval($mb_strs[1]);
	$i=strval($mb_strs[2]);
	$s=strval($mb_strs[3]);
	$n=strval($mb_strs[4]);
	$t=strval($mb_strs[5]);
	$f=strval($mb_strs[6]);
	$j=strval($mb_strs[7]);
	$p=strval($mb_strs[8]);

        $result_big = mysqli_query($connect, "SELECT (big) from $table WHERE user = '$un'");
	$big_res = $result_big->fetch_row();
	$big_strs = explode(":",$big_res[0]);

	$o=strval($big_strs[4]);
	$c=strval($big_strs[0]);
	$ee=strval($big_strs[1]);
	$a=strval($big_strs[2]);
	$nn=strval($big_strs[3]);

        $result_ab = mysqli_query($connect, "SELECT (ab) from $table WHERE user = '$un'");
	$ab_res = $result_ab->fetch_row();
	$ab_strs = explode(":",$ab_res[0]);

	$aa=strval($ab_strs[0]);
	$b=strval($ab_strs[1]);

print<<<view
        <table width="100%">
        <tr><td colspan="4"><center><b>$name's Personality Results</b></center></td></tr>
	<tr><td><br><br></td></tr>

	<tr><td colspan="4"><center><u>MBTI</u></center></td></tr>
	<tr><td>$e</td><td>$s</td><td>$t</td><td>$j</td></tr>
	<tr><td>$i</td><td>$n</td><td>$f</td><td>$p</td></tr>
	<tr><td colspan="4">$type</td></tr>

	<tr><td><br><br></td></tr>

	<tr><td colspan="4"><center><u>Big 5</u></center></td></tr>
	<tr><td>$c</td><td>$ee</td><td>$a</td><td>$nn</td></tr>
	<tr><td colspan="4"><center>$o</center></td></tr>

	<tr><td><br><br></td></tr>

	<tr><td colspan="4"><center><u>Type A/B</u></center></td></tr>
	<tr><td colspan="2">$aa</td><td colspan="2">$b</td></tr>

	</table>
        </center>
        </body>
        </html>
view;
        mysqli_close($connect);
}

view_all();

?>



</div>

</div>
</html>
