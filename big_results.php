<html>
<head>
<title>The Big Five</title>
	<link rel="stylesheet" href="./outline.css" type="text/css" name="style1">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script>
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

<div id="container" style="height: 425em">
	<a href="./home.php"><img src="./logo.png" id="logo"></a>

<div id="title">
	<h1>The Big Five Quiz</h1>
</div>

<div id="anchor"></div>
<div id="info">
	<center><div id="info_title">Brain Surge Site Navigation</div></center>
	<h4><i>Personality Quizzes</i></h4>
	<ul><li><a href="./mb.php">MBTI</a></li>
	    <li style="color: gray">The Big Five</li>
	    <li><a href="./typeAB.php">Type A/B</a></li>
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
				<form method="post" action="big_results.php">
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
				<form method="post" action="big_results.php"><input type="submit" id="logout" name="logout" value="Log Out"></form>
			</div>
WELCOME;
	}	
	if(isset($_POST["logout"])){
		setcookie("user", "", time() - 3600);
		header("Location: big_results.php");
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
			header("Location: big_results.php");
		}
		mysqli_close($connect);
	}
?>

<div id="main">

	<?php

	function score(){

	$type="";

	$o=8;
	$c=14;
	$e=20;
	$a=14;
	$n=38;

	for($k=1; $k<51; $k++){
	
		$question=$_POST["q".$k];
		
		if($k%5===0){//Openness
	
			if(($k===10)||($k===20)||($k===30)){
				$o=$o-$question;
			}else{
				$o=$o+$question;
			}

		}

		if($k%5===1){//Extraversion
	
			if($k%2===0){
				$e=$e-$question;
			}else{
				$e=$e+$question;
			}

		}

		if($k%5===2){//Agreeableness
	
			if(($k%2===0)&&($k!==42)){
				$a=$a-$question;
			}else{
				$a=$a+$question;
			}

		}

		if($k%5===3){//Conscientiousness
	
			if(($k%2===0)&&($k!==48)){
				$c=$c-$question;
			}else{
				$c=$c+$question;
			}

		}

		if($k%5===4){//Neuroticism
	
			if(($k===9)||($k===19)){
				$n=$n+$question;
			}else{
				$n=$n-$question;
			}

		}

	}
	return (array($o,$c,$e,$a,$n));
	}

	function results(){

		$res=score();		
		$types=array();

		for($i=0; $i<5; $i++){
			$perc=$res[$i]/40*100;
			array_push($types, $perc);
		}

		$str=$types[0]."% on Openness to Experience<br><br>".
			$types[1]."% on Conscientiousness<br><br>".
			$types[2]."% on Extraversion<br><br>".
			$types[3]."% on Agreeableness<br><br>".
			$types[4]."% on Neuroticism<br><br>";
		
	if(!isset($_COOKIE["user"])){
		$act="./login.php";
	}else{
		$act="./profile.php";
	}
	
print<<<RESULTS
		<center>Your Big 5 results are<br></center>
		<h2>$str</h2>
		<form method="post" action=$act>
		<center><input class="btn" type="submit" value="Save your results to your profile">
		</form>
		<br>
		<br>
RESULTS;

	}


	if(isset($_POST["big5"])){
		results();
	}else{
		print<<<ERR
		<center>Oops! Something went wrong.<br>
ERR;
	}
	?>
		Learn more about what each category of the Big 5 represents:
		</center>
		<ul>
		<li><a href="http://personality-testing.info/printable/big-five-personality-test.pdf">Basic information about the big 5</a></li>
		<li><a href="https://www.123test.com/big-five-personality-theory/">Another opinion on the Big 5 traits</a></li>
</ul>
</div>
<div id="footer" style="margin-top: 560em">
	<br><center>BrainSurge.com &copy; 2014 || Mitra Enterprises || Developers: Evan Johnston &amp; Irene Jea <br>
	<a href="./info.php">About the Developers</a></center>
</div>
</div>
</html>
