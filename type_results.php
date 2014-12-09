<html>
<head>
	<title>Type A Type B</title>
	<link rel="stylesheet" href="./outline.css" type="text/css" name="style1">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"> </script>
	<script type="text/javascript">
		function sticky_relocate() {
			var window_top = $(window).scrollTop();
			var div_top = $('#anchor').offset().top;
			if (window_top > div_top){
				$('#info').addClass('sticky');
			}
			else{
				$('#info').removeClass('sticky');
			}
		}	
		$(function() {
			$(window).scroll(sticky_relocate);
			sticky_relocate();
		});
	</script>
</head>

<div id="container" style="height: 215em">
	<a href="./home.php"><img src="./logo.png" id="logo"></a>

<div id="title">
	<h1>Personality Type A/B Quiz</h1>
</div>

<div id="anchor"></div>
<div id="info">
	<center><div id="info_title">Brain Surge Site Navigation</div></center>
	<h4><i>Personality Quizzes</i></h4>
	<ul><li><a href="./mb.php">MBTI</a></li>
	    <li><a href="./big5.php">The Big Five</a></li>
	    <li style="color: gray">Type A/B</li>
	</ul>

	<!-- takes them to profile page, or if they aren't logged in, to register/login page-->
<?php 
	if(!isset($_COOKIE["user"])){
		print "<a href='login.php'> <h4><i>Your Profile</i></h4></a>";
	}
	else{
		print "<a href='profile.php'> <h4><i>Your Profile</i></h4></a>";
	}
?>
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
				<form method="post" action="type_results.php">
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
				Welcome back, <a href="profile.php"><u><b>{$_COOKIE["user"]}</b></u></a>
				<form method="post" action="type_results.php"><input type="submit" id="logout" name="logout" value="Log Out"></form>
			</div>
WELCOME;
	}	
	if(isset($_POST["logout"])){
		setcookie("user", "", time() - 3600);
		header("Location: type_results.php");
	}
	if(isset($_POST["login"])){
		if(!empty($_POST["username"]) && !empty($_POST["password"])){
			$un = $_POST["username"];
			$pw = $_POST["password"];
			login($un, $pw);
		}
		else{
			echo "<script type = 'text/javascript'>
				alert('Please fill in both fields to login.') </script>";
		}
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
			$name = $row[0];
			setcookie("user", $name);
			header("Location: type_results.php");
		}
		mysqli_close($connect);
	}
?>


<div id="main">

	<?php

	function score(){
	
		$score=0;

		for($i=1; $i<21; $i++){
			$question=$_POST["q".$i];
			$score=$score+$question;
		}
		return $score;
	}

	function results(){
		$score=score();
		$percA=floor($score/380*100);
		$percB=100-$percA;

	if(!isset($_COOKIE["user"])){
		$act="./login.php";
	}else{
		$act="./profile.php";
	}

	print<<<RESULTS

		<center>Your Type A / Type B results are: 
		<h2>$percA% Type A</h2><br>
		or
		<h2>$percB% Type B</h2><br>
		<form method="post" action=$act>
		<input class="btn" type="submit" value="Save your results to your profile">
		</form>

RESULTS;

	}


	if(isset($_POST["typeAB"])){
		results();
	}else{
		print<<<ERR
		<center>Oops! Something went wrong.<br>
ERR;
	}

	?>
		Learn more about your personality type:
		</center>
		<ul>
		<li><a href="http://stress.about.com/od/understandingstress/a/type_a_person.htm">Type A personality traits</a></li>
		<li><a href="http://www.huffingtonpost.com/2014/01/21/whats-so-wrong-with-being_0_n_4575678.html">The benefits of being a "B"</a></li>
</ul>


</div>

<div id="footer" style="margin-top: 280em">
	<br><center>BrainSurge.com &copy; 2014 || Mitra Enterprises || Developers: Evan Johnston &amp; Irene Jea <br>
	<a href="./info.php">About the Developers</a></center>
</div>

</div>
</html>
